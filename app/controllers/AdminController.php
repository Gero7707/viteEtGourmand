<?php
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../../core/Auth.php';
require_once __DIR__ . '/../models/HoraireModel.php';
require_once __DIR__ . '/../services/MailService.php';

class AdminController{


    private UserModel $users;
    private HoraireModel $horaire;

    private MailService $mail;

    public function __construct(){
        $this->users = new UserModel();
        $this->horaire = new HoraireModel();
        $this->mail = new MailService();
    }
    public function dashboard(){
        Auth::checkAdmin();
        $horaire = $this->horaire->getHoraire();
        $employes = $this->users->getEmploye();
        require_once __DIR__ . '/../views/admin/adminDashboard.php';
    }

    public function showRegisterEmploye(){
        Auth::checkAdmin();
        $horaire = $this->horaire->getHoraire();
        require_once __DIR__ . '/../views/admin/registerEmploye.php';
    }

    public function registerEmploye(){
        Auth::checkAdmin();
        Auth::verifyCsrfToken();
        $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
        if (!$email) {
            $error = "L'adresse email n'est pas valide !";
            header('Location: /admin/employe-register?error=' . urlencode($error));
            exit();
        }

        $emailExists = $this->users->findByEmail($email);
        if($emailExists){
            $error = "Cet email est déjà utilisé !";
            header('Location: /admin/employe-register?error=' . urlencode($error));
            exit();
        }
        
        if($_POST['password'] !== $_POST['password_confirm']){
            $error = "Les deux mots de passe ne correspondent pas !";
            header('Location: /admin/employe-register?error=' . urlencode($error));
            exit();
        }

        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z\d]).{10,}$/', $_POST['password'])) {
            $error = "Le mot de passe doit contenir au moins 10 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial.";
            header('Location: /admin/employe-register?error=' . urlencode($error));
            exit();
        }

        $nom = trim($_POST['nom']);
        $prenom = trim($_POST['prenom']);

        if (empty($nom) || empty($prenom)) {
            $error = "Le nom et le prénom sont obligatoires !";
            header('Location: /admin/employe-register?error=' . urlencode($error));
            exit();
        }

        $gsm = $_POST['gsm'];
        if(empty(trim($gsm))){
            $error = "Le numéro de téléphone est obligatoire !";
            header('Location: /admin/employe-register?error=' . urlencode($error));
            exit();
        }

        $ville = $_POST['ville'];
        if(empty(trim($ville))){
            $error = "La ville est obligatoire !";
            header('Location: /admin/employe-register?error=' . urlencode($error));
            exit();
        }

        $adresse = $_POST['adresse'];
        if(empty(trim($adresse))){
            $error = "L'adresse est obligatoire !";
            header('Location: /admin/employe-register?error=' . urlencode($error));
            exit();
        }

        $codePostal = $_POST['code_postal'];
        if(empty(trim($codePostal))){
            $error = "Le code postal est obligatoires !";
            header('Location: /admin/employe-register?error=' . urlencode($error));
            exit();
        }

        $data = [
            'email' => $email,
            'password' => password_hash($_POST['password'], PASSWORD_BCRYPT),
            'nom' => $nom,
            'prenom' => $prenom,
            'gsm' => $gsm,
            'ville' => $ville,
            'adresse' => $adresse,
            'code_postal' => $codePostal,
            'role_id' => 2
        ];

        $id = $this->users->createEmploye($data);

        $titre = "Votre compte employé .";
        $message = "Bonjour . Votre compte employé a été créé . Veuillez vous rapprocher de votre administrateur afin de récupérer votre mot de passe . ";
        $this->mail->sendEmail($email, $titre, $message);

        $successMessage = "Le compte employé a été créé avec succès .";
        header('location: /admin/dashboard?success=' . urlencode($successMessage));
        exit();
    }
}