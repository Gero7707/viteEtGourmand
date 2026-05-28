<?php
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../../core/Auth.php';
require_once __DIR__ . '/../models/HoraireModel.php';

class AdminController{


    private UserModel $users;
    private HoraireModel $horaire;

    public function __construct(){
        $this->users = new UserModel();
        $this->horaire = new HoraireModel();
    }
    public function dashboard(){
        Auth::checkAdmin();
        $horaire = $this->horaire->getHoraire();
        $employes = $this->users->getEmploye();
        require_once __DIR__ . '/../views/admin/adminDashboard.php';
    }


}