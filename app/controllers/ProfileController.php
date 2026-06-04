<?php
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../models/HoraireModel.php';
require_once __DIR__ . '/../models/CommandeModel.php';


class ProfileController{
    private UserModel $user;

    private HoraireModel $horaire;

    private CommandeModel $commandes;

    public function __construct(){
        $this->horaire = new HoraireModel();
        $this->user = new UserModel();
        $this->commandes = new CommandeModel();
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
}