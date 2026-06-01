<?php
require_once __DIR__ . '/../models/AvisModel.php';
require_once __DIR__ . '/../models/HoraireModel.php';
require_once __DIR__ . '/../models/CommandeModel.php';

class AvisController{
    private AvisModel $avis;

    private HoraireModel $horaire;

    private CommandeModel $commande;

    public function __construct(){
        $this->avis = new AvisModel();
        $this->horaire = new HoraireModel();
        $this->commande = new CommandeModel();
    }

    public function index(){
        $avis = $this->avis->getAvis('valide');
        $horaire = $this->horaire->getHoraire();
        require_once __DIR__ . '/../views/avis/avis.php';
    }

    public function avisToValidate(){
        $horaire = $this->horaire->getHoraire();
        $avis = $this->avis->getAvis('en_attente');
        require_once __DIR__ . '/../views/employe/validerAvis.php';
    }

    public function showAvisForm(int $id){
        Auth::checkAuth();
        $horaire = $this->horaire->getHoraire();
        $commande = $this->commande->findById($id);
        $utilisateurId = $_SESSION['utilisateur_id'];
        if($utilisateurId === $commande['utilisateur_id'] && $commande['statut'] === "terminee"){
            require_once __DIR__ . '/../views/avis/avisForm.php';
        }else {
            $error = "Accès non autorisé .";
            header('location: /commandes/'. $id . '?error=' . urlencode($error));
            exit();
        }
    }

    public function noterCommande(int $id){
        Auth::checkAuth();
        Auth::verifyCsrfToken();
        $commande = $this->commande->findById($id);
        $utilisateurId = $_SESSION['utilisateur_id'];
        if($utilisateurId === $commande['utilisateur_id'] && $commande['statut'] === "terminee"){
            $note = $_POST['note'];
            if(empty($note)){
                $error ="Veuillez choisir une note .";
                header('location: /avis/noter/'. $id . '?error=' . urlencode($error));
                exit();
            }

            $description = $_POST['description'];
            if(empty(trim($description))){
                $error ="Veuillez remplir tous les champs du formulaire .";
                header('location: /avis/noter/'. $id . '?error=' . urlencode($error));
                exit();
            }

            $data = [
                'note' => $_POST['note'],
                'description' => $_POST['description'],
                'statut' => 'en_attente',
                'date_avis' => date('Y-m-d H:i:s'),
                'commande_id' => $id ,
                'utilisateur_id' => $_SESSION['utilisateur_id']
            ];

            $avis = $this->avis->noterCommande($data);

            $succesMessage = "Votre avis est en attente de validation .";
            header('location: /commandes/'. $id  . '?success=' . urlencode($succesMessage));
            exit();


        }else{
            $error = "Une erreur est survenu";
            header('Location: /avis/noter/' . $id . '?error=' . urlencode($error));
            exit();
        }
    }

    public function showEditForm(int $id){
        Auth::checkAuth();
        $horaire = $this->horaire->getHoraire();
        $avis = $this->avis->findById($id);
        $utilisateurId = $_SESSION['utilisateur_id'];
        if($utilisateurId === $avis['utilisateur_id'] && $avis['statut'] === 'valide'){
            require_once __DIR__ . '/../views/avis/avisUpdate.php';
        }else {
            $error = "Accès non autorisé .";
            header('location: /avis?error=' . urlencode($error));
            exit();
        }
    }

    public function updateAvis(int $id){
        Auth::checkAuth();
        Auth::verifyCsrfToken();
        $avis = $this->avis->findById($id);
        $utilisateurId = $_SESSION['utilisateur_id'];
        
        if($utilisateurId === $avis['utilisateur_id'] && $avis['statut'] === "valide"){
            $note = $_POST['note'];
            if(empty($note)){
                $error ="Veuillez choisir une note .";
                header('location: /avis/edit/'. $id . '?error=' . urlencode($error));
                exit();
            }

            $description = $_POST['description'];
            if(empty(trim($description))){
                $error ="Veuillez remplir tous les champs du formulaire .";
                header('location: /avis/edit/'. $id . '?error=' . urlencode($error));
                exit();
            }

            $data = [
                'avis_id' => $avis['avis_id'],
                'note' => $_POST['note'],
                'description' => $_POST['description'],
                'statut' => 'en_attente',
                'date_avis' => date('Y-m-d H:i:s')
            ];

            $this->avis->updateAvis($data);

            $succesMessage = "Votre avis est en attente de validation .";
            header('location: /avis?success=' . urlencode($succesMessage));
            exit();


        }else{
            $error = "Une erreur est survenu";
            header('Location: /avis/edit/' . $id . '?error=' . urlencode($error));
            exit();
        }
    }
}