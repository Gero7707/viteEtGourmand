<?php
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../models/LoginAttemptModel.php';
require_once __DIR__ . '/../services/MailService.php';
require_once __DIR__ . '/../models/HoraireModel.php';
require_once __DIR__ . '/../../core/Auth.php';

class AuthController{
    private UserModel $users;
    private LoginAttemptModel $loginAttempts;

    private MailService $mailService;

    private HoraireModel $horaire;

    public function __construct(){
        $this->users = new UserModel();
        $this->loginAttempts = new LoginAttemptModel();
        $this->mailService = new MailService();
        $this->horaire = new HoraireModel();
    }

    /**
     * GET /auth/login — Affiche le formulaire de connexion
     */
    public function loginForm(){
        $horaire = $this->horaire->getHoraire();
        require_once __DIR__ . '/../views/auth/login.php';
    }

    /**
     * POST /auth/login — Traite la soumission du formulaire de connexion
     */
    public function login(){
        Auth::verifyCsrfToken();
        
        $input = $_POST['login'] ?? '';

        // Valider que le champ n'est pas vide
        if (empty($input) || empty($_POST['password'])) {
            $error = "Veuillez remplir tous les champs !";
            header('Location: /auth/login?error=' . urlencode($error));
            exit();
        }
        if (!filter_var($input, FILTER_VALIDATE_EMAIL)) {
            $error = "Veuillez entrer une adresse email valide !";
            header('Location: /auth/login?error=' . urlencode($error));
            exit();
        }

        $user = $this->users->findByEmail($input);

        $ip = $_SERVER['REMOTE_ADDR'];
        $emailToStore = $user ? $user['email'] : $input;

        if($user && password_verify($_POST['password'], $user['password'])){
            // Régénérer l'id de session contre le session fixation
            session_regenerate_id(true);

            if($user['actif'] === 0){
                $error = "Vous n'avez plus accès à ce compte .";
                header('Location: /auth/login?error=' . urlencode($error));
                exit();
            }

            $_SESSION['utilisateur_id'] = $user['utilisateur_id'];
            $_SESSION['role_id'] = $user['role_id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['prenom'] = $user['prenom'];
            $_SESSION['nom'] = $user['nom'];
            $_SESSION['gsm'] = $user['gsm'];
            $_SESSION['ville'] = $user['ville'];
            $_SESSION['code_postal'] = $user['code_postal'];
            $_SESSION['adresse'] = $user['adresse'];

            $this->loginAttempts->resetAttempts($ip,$emailToStore);
            $_SESSION['flash_bienvenue'] = true;
            if($_SESSION['role_id'] === 3){
                header('location: /admin/dashboard');
                exit();
            } else if($_SESSION['role_id'] === 2){
                header('location: /employe/dashboard');
                exit();
            }else {
                header('location: /');
                exit();
            }
        } else {
            
            $this->loginAttempts->addAttempt($ip,$emailToStore);
            $attempts = $this->loginAttempts->getAttempts($ip,$emailToStore);
            if(count($attempts) >= 5 && $user){
                $error = "Vous avez tenté de vous connecter plus de 5 fois sans succés , par sécurité vous devez réessyer ultérieurement !";
                $subject = "Tentatives de connexions ratées !";
                $conclusion = "<p>Vous avez 5 tentatives de connexion infructueuses à votre compte ! </p>
                <p>Si c'est un oubli,ou si ce n'est pas vous qui êtes à l'origine des tentatives de connexion ,  veuillez modifier votre mot de passe .</p> ";

                $imageHaut = '<img src="https://restaurationviteetgourmand.alwaysdata.net/assets/img/bandeau-email.jpg" 
                    alt="Vite &amp; Gourmand" 
                    width="600" 
                    style="display: block; width: 100%; max-width: 600px; height: auto; border: 0;">';
                $imageBas = '<img src="https://restaurationviteetgourmand.alwaysdata.net/assets/img/cuistot.jpg" 
                    alt="Vite &amp; Gourmand" 
                    width="600" 
                    style="display: block; width: 100%; max-width: 600px; height: auto; border: 0;">';
                    
                $body =$imageHaut . $conclusion . $imageBas;
                $this->mailService->sendEmail($user['email'],$subject,$body);
                header('location: /?error=' . urlencode($error));
                exit();
            }elseif(count($attempts) >= 5 ){
                $error = "Vous avez tenté de vous connecter plus de 5 fois sans succés , par sécurité vous devez réessyer ultérieurement !";
                header('location: /?error=' . urlencode($error));
                exit();
            }
            
            $error = "Identifiants et mot de passe incorrects !";
            header('Location: /auth/login?error=' . urlencode($error));
            exit();
        }

        
    }

    public function logOut(){
        session_destroy();
        header('Location: /');
        exit();
    }

    /**
     * GET /auth/register — Affiche le formulaire d'inscription
     */
    public function registerForm(){
        $horaire = $this->horaire->getHoraire();
        require_once __DIR__ . '/../views/auth/register.php';
    }

    /**
     * POST /auth/register — Traite la soumission du formulaire d'inscription
     */
    public function register(){
        Auth::verifyCsrfToken();
        if (!isset($_POST['rgpd'])) {
            $error = "Vous devez accepter la politique de confidentialité.";
            header('Location: /auth/register?error=' . urlencode($error));
            exit();
        }
        // Validation de l'email
        $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
        if (!$email) {
            $error = "L'adresse email n'est pas valide !";
            header('Location: /auth/register?error=' . urlencode($error));
            exit();
        }

        $emailExists = $this->users->findByEmail($email);
        if($emailExists){
            $error = "Cet email est déjà utilisé !";
            header('Location: /auth/register?error=' . urlencode($error));
            exit();
        }

        if($_POST['password'] !== $_POST['password_confirm']){
            $error = "Les deux mots de passe ne correspondent pas !";
            header('Location: /auth/register?error=' . urlencode($error));
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
            header('Location: /auth/register?error=' . urlencode($error));
            exit();
        }

        $nom = trim($_POST['nom']);
        $prenom = trim($_POST['prenom']);

        if (empty($nom) || empty($prenom)) {
            $error = "Le nom et le prénom sont obligatoires !";
            header('Location: /auth/register?error=' . urlencode($error));
            exit();
        }

        $data = [
            'email' => $email,
            'password' => password_hash($_POST['password'], PASSWORD_BCRYPT),
            'nom' => $nom,
            'prenom' => $prenom,
            'role_id' => 1
        ];
        
        $id = $this->users->createUser($data);
        $titre = "Votre compte a été créé ! .";

        $lien = getenv('APP_URL') . '/auth/login';
            $bouton = '
                <div style="text-align: center; padding: 24px 0;">
                    <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td align="center" style="background-color: #d4af37; border-radius: 6px;">
                        <a href="' . $lien . '" target="_blank"
                            style="display: inline-block; padding: 14px 28px; font-family: Arial, Helvetica, sans-serif; font-size: 16px; font-weight: bold; color: #1a2238; text-decoration: none;">
                            Connexion
                        </a>
                        </td>
                    </tr>
                    </table>
                </div>';

        $imageHaut = '<img src="https://restaurationviteetgourmand.alwaysdata.net/assets/img/bandeau-email.jpg" 
            alt="Vite &amp; Gourmand" 
            width="600" 
            style="display: block; width: 100%; max-width: 600px; height: auto; border: 0;">';
        $imageBas = '<img src="https://restaurationviteetgourmand.alwaysdata.net/assets/img/cuistot.jpg" 
            alt="Vite &amp; Gourmand" 
            width="600" 
            style="display: block; width: 100%; max-width: 600px; height: auto; border: 0;">';

        $conclusion ="<p>Bonjour . Votre compte  a été créé . </p> 
        <p>Merci pour votre confiance . Vous pouvez vous connecter via ce lien et commander les menus qui vous plaisent .  </p>
        <p>Vite &amp; Gourmand vous souhaite une bonne journée. </p> ";
        
        $message = $imageHaut . $conclusion . $bouton. $imageBas;
        $this->mailService->sendEmail($email, $titre, $message);
        $succesMessage = "Votre compte a été créé avec succes .";
        header('location: /auth/login?success=' . urlencode($succesMessage));
        exit();
    }

    

}