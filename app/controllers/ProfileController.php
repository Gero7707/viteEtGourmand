<?php
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../models/HoraireModel.php';
require_once __DIR__ . '/../models/CommandeModel.php';
require_once __DIR__ . '/../models/AvisModel.php';
require_once __DIR__ . '/../services/MailService.php';


class ProfileController{
    private UserModel $user;

    private HoraireModel $horaire;

    private CommandeModel $commandes;

    private MailService $mailService;

    private AvisModel $avis;

    public function __construct(){
        $this->horaire = new HoraireModel();
        $this->user = new UserModel();
        $this->commandes = new CommandeModel();
        $this->mailService = new MailService();
        $this->avis = new AvisModel();
    }

    public function showProfile(){
        Auth::checkAuth();
        $id = $_SESSION['utilisateur_id'];
        $commandes = $this->commandes->getCommandes($id);
        $horaire = $this->horaire->getHoraire();
        $user = $this->user->findById($id);
        require_once __DIR__ . '/../views/user/userProfile.php';
    }

    public function editProfile(){
        Auth::checkAuth();
        $id = $_SESSION['utilisateur_id'];
        $horaire = $this->horaire->getHoraire();
        $user = $this->user->findById($id);
        require_once __DIR__ . '/../views/user/editProfile.php';
    }

    public function edit(){
        Auth::checkAuth();
        Auth::verifyCsrfToken();
        $id = $_SESSION['utilisateur_id'];
        $sessionEmail = $_SESSION['email'];
        
        $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
        if (!$email ){
            $error = "L'adresse email n'est pas valide !";
            header('Location: /profile/edit?error=' . urlencode($error));
            exit();
        }

        if($sessionEmail !== $email){
            $emailExists = $this->user->findByEmail($email);
            if($emailExists){
                $error = "Cet email est déjà utilisé !";
                header('Location: /profile/edit?error=' . urlencode($error));
                exit();
            }
        }

        if(empty(trim($_POST['nom'])) || empty(trim($_POST['prenom']))){
            $error = "Vous devez indiquer au minimum votre nom et votre prénom !";
            header('Location: /profile/edit?error=' . urlencode($error));
            exit();
        }

        $nom = trim($_POST['nom']);
        $prenom =  trim($_POST['prenom']);
        $gsm = trim($_POST['gsm']);
        $ville = trim($_POST['ville']);
        $adresse = trim($_POST['adresse']);
        $codePostal = trim($_POST['code_postal']);

        $this->user->updateUser($id,$nom,$prenom,$email,$gsm,$ville,$adresse,$codePostal);
        $_SESSION['email'] = $email;
        $_SESSION['prenom'] = $prenom;
        $_SESSION['gsm'] = $gsm;
        $_SESSION['ville'] = $ville;
        $_SESSION['adresse'] = $adresse;
        $_SESSION['code_postal'] = $codePostal;
        $succesMessage = "Votre profil a été mis à jour avec succès .";
        header('location: /profile?success='  . urlencode($succesMessage));
        exit();
    }

    public function showSupprimerProfil(){
        Auth::checkAuth();
        $horaire = $this->horaire->getHoraire();
        require_once __DIR__ . '/../views/auth/supprimerProfil.php';
    }

    public function supprimerProfil(){
        Auth::checkAuth();
        Auth::verifyCsrfToken();
        $id = $_SESSION['utilisateur_id'];
        $email = $_SESSION['email'];
        $this->user->supprimerCompteUtilisateur($id);
        $this->avis->masquerAvisUtilisateur($id);

        $titre = 'Votre profil a été supprimé !';
            
        $imageHaut = '<img src="https://restaurationviteetgourmand.alwaysdata.net/assets/img/bandeau-email.jpg" 
                alt="Vite &amp; Gourmand" 
                width="600" 
                style="display: block; width: 100%; max-width: 600px; height: auto; border: 0;">';

        $imageBas = '<img src="https://restaurationviteetgourmand.alwaysdata.net/assets/img/cuistot.jpg" 
                alt="Vite &amp; Gourmand" 
                width="600" 
                style="display: block; width: 100%; max-width: 600px; height: auto; border: 0;">';

        $nom = $_SESSION['prenom'] . ' ' . $_SESSION['nom'];

        $conclusion = "<p>Bonjour {$nom}, votre compte chez Vite &amp; Gourmand a été supprimé. </p>
        <p>Nous sommes vraiment désolé de vous voir partir .</p>
        <p>Vos données personnelles ont été supprimées de notre  base de données . </p>
        <p>Cependant les données concernant vos commandes sont conservées pendant dix ans en respectant le rgpd. </p>
        <p>Vite &amp; Gourmand vous souhaite une bonne journée. </p>";
        $message =$imageHaut .  $conclusion . $imageBas;

        $this->mailService->sendEmail($email , $titre , $message);

        session_destroy();
        $succesMessage = "Votre profil a été supprimé avec succès .";
        header('location: /?success='  . urlencode($succesMessage));
        exit();
    }
}