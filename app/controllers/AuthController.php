<?php
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../models/LoginAttemptModel.php';
require_once __DIR__ . '/../services/MailService.php';
require_once __DIR__ . '/../../core/Auth.php';

class AuthController{
    private UserModel $users;
    private LoginAttemptModel $loginAttempts;

    private MailService $mailService;

    public function __construct(){
        $this->users = new UserModel();
        $this->loginAttempts = new LoginAttemptModel();
        $this->mailService = new MailService();
    }

    /**
     * GET /auth/login — Affiche le formulaire de connexion
     */
    public function loginForm(){
        Auth::generateCsrfToken();
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
            session_regenerate_id();

            $_SESSION['utilisateur_id'] = $user['utilisateur_id'];
            $_SESSION['role_id'] = $user['role_id'];

            $this->loginAttempts->resetAttempts($ip,$emailToStore);
            
            if($_SESSION['role_id'] === 3){
                header('location: /admin/dashboard');
                exit();
            } else {
                header('location: /');
                exit();
            }
        } else {
            
            $this->loginAttempts->addAttempt($ip,$emailToStore);
            $attempts = $this->loginAttempts->getAttempts($ip,$emailToStore);
            if(count($attempts) >= 5 && $user){
                $error = "Vous avez tenté de vous connecter plus de 5 fois sans succés , par sécurité vous devez réessyer ultérieurement !";
                $subject = "Tentatives de connexions ratées !";
                $body = "Vous avez 5 tentatives de connexion infructueuses à votre compte ! Si c'est un oubli, veuillez modifier votre mot de passe . ";
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
        header('Location: /auth/login');
        exit();
    }

    /**
     * GET /auth/register — Affiche le formulaire d'inscription
     */
    public function registerForm(){
        Auth::generateCsrfToken();
        require_once __DIR__ . '/../views/auth/register.php';
    }

    /**
     * POST /auth/register — Traite la soumission du formulaire d'inscription
     */
    public function register(){
        Auth::verifyCsrfToken();

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
        if(strlen($_POST['password']) < 14){
            $error = "Le mot de passe ne contient le nombre minimum de 14 caractères ! Veuillez recommencer svp .";
            header('location:/auth/register?error=' . urlencode($error));
            exit();
        }

        $nom = htmlspecialchars($_POST['nom'] ?? '', ENT_QUOTES, 'UTF-8');
        $prenom = htmlspecialchars($_POST['prenom'] ?? '', ENT_QUOTES, 'UTF-8');

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
        header('location: /auth/login');
        exit();
    }

    

}