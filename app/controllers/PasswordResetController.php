<?php
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../services/MailService.php';


class PasswordResetController{
    private UserModel $users;
    private MailService $mailService;

    public function __construct(){
        $this->users = new UserModel();
        $this->mailService = new MailService();
    }

    public function forgotPasswordForm(){
        require_once __DIR__ . '/../views/auth/forgotPassword.php';
    }

    public function forgotPassword(){
        Auth::verifyCsrfToken();
        $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
        if (!$email ){
            $error = "L'adresse email n'est pas valide !";
            header('Location: /auth/forgot-password?error=' . urlencode($error));
            exit();
        }

        $findEmail = $this->users->findByEmail($email);
        
        if($findEmail){
            $subject = "Réinitialisation de mot de passe .";
            $token = bin2hex(random_bytes(32));
            $body = 'Cliquez sur ce lien : '. getenv('APP_URL') .'/auth/reset-password?token=' . $token;
            $expires = date('Y-m-d H:i:s', time() + 3600);
            $this->users->saveResetToken($email, $token, $expires);
            $this->mailService->sendEmail($email,$subject,$body);
            $succesMessage = "Lien lien de réinitialisation a été envoyé ! Verifiez votre boîte de reception .";
            header('location: /auth/login?success='  . urlencode($succesMessage));
            exit();
        }else{
            $error = "Email n'existe pas en base de données !";
            header('Location: /auth/forgot-password?error=' . urlencode($error));
            exit();
        }
    }


    public function resetPasswordForm(){
        $token = $_GET['token'] ?? '';
        require_once __DIR__ . '/../views/auth/resetPassword.php';
    }
    public function resetPassword(){
        Auth::verifyCsrfToken();
        $token = $_POST['token'];
        $user = $this->users->findByResetToken($token);
        if(!$user){
            $error = "Cet utilisateur n'existe pas ! Merci de créer un compte valide ! ";
            header('location: /auth/reset-password?error=' . urlencode($error));
            exit();
        }
        if($user['reset_token_expires_at'] < date('Y-m-d H:i:s', time())){
            $error = "Votre token a expiré !";
            header('location: /auth/reset-password?error=' . urlencode($error));
            exit();
        }else{
            if($_POST['password'] !== $_POST['password_confirm']){
                $error = "Les deux mots de passe ne correspondent pas !";
                header('Location: /auth/reset-password?error=' . urlencode($error));
                exit();
            }
            if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z\d]).{10,}$/', $_POST['password'])) {
                //(?=.*[a-z]) → contient au moins une minuscule
                // (?=.*[A-Z]) → contient au moins une majuscule
                // (?=.*\d) → contient au moins un chiffre
                // (?=.*[^a-zA-Z\d]) → contient au moins un caractère qui n'est ni lettre ni chiffre (= spécial)
                // .{10,} → 10 caractères minimum
                // ^ et $ → du début à la fin de la chaîne
                $error = "Le mot de passe doit contenir au moins 10 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial.";
                header('Location: /auth/reset-password?error=' . urlencode($error));
                exit();
            }

            $hashedPassword= password_hash($_POST['password'], PASSWORD_BCRYPT);
            $id = $user['utilisateur_id'] ;
            $this->users->updatePassword($id , $hashedPassword);
            $this->users->clearResetToken($id);
            $email = $user['email'];
            $subject = "Mot de passe réinitialsé !";
            $body = "Vous avez réinitialsé votre mot de passe avec succès ! ";
            $this->mailService->sendEmail($email,$subject,$body);
            $succesMessage = "Vous avez réinitialsé votre mot de passe avec succès !";
            header('location: /auth/login?success=' . urlencode($succesMessage));
            exit();
        }
    }
}