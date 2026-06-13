<?php
require_once __DIR__ . '/../../core/Auth.php';
require_once __DIR__ . '/../models/HoraireModel.php';
require_once __DIR__ . '/../models/CommandeModel.php';



class EmployeController{
    private HoraireModel $horaire;

    private CommandeModel $commandes;

    public function __construct(){
        $this->horaire = new HoraireModel();
        $this->commandes = new CommandeModel();
    }

    public function dashboard(){
        Auth::checkEmploye();
        $commandes = $this->commandes->getAllCommandes();
        $horaire = $this->horaire->getHoraire();
        require_once __DIR__ . '/../views/employe/employeDashboard.php';
    }
}