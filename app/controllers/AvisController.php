<?php
require_once __DIR__ . '/../models/AvisModel.php';
require_once __DIR__ . '/../models/HoraireModel.php';

class AvisController{
    private AvisModel $avis;

    private HoraireModel $horaire;

    public function __construct(){
        $this->avis = new AvisModel();
        $this->horaire = new HoraireModel();
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
}