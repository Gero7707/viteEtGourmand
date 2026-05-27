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
        $id = $_SESSION['utilisateur_id'];
        $commandes = $this->commandes->getCommandes($id);
        $horaire = $this->horaire->getHoraire();
        $user = $this->user->findById($id);
        require_once __DIR__ . '/../views/user/userProfile.php';
    }
}