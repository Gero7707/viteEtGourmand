<?php
require_once __DIR__ . '/../../core/Auth.php';
require_once __DIR__ . '/../models/HoraireModel.php';



class EmployeController{
    private HoraireModel $horaire;

    public function __construct(){
        $this->horaire = new HoraireModel();
    }

    public function dashboard(){
        Auth::checkEmploye();
        $horaire = $this->horaire->getHoraire();
        require_once __DIR__ . '/../views/employe/employeDashboard.php';
    }
}