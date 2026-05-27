<?php
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../models/HoraireModel.php';


class ProfileController{
    private UserModel $user;

    private HoraireModel $horaire;

    public function __construct(){
        $this->horaire = new HoraireModel();
        $this->user = new UserModel();
    }

    public function showProfile(){
        $id = $_SESSION['utilisateur_id'];
        $horaire = $this->horaire->getHoraire();
        $user = $this->user->findById($id);
        require_once __DIR__ . '/../views/user/userProfile.php';
    }
}