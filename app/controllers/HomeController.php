<?php
require_once __DIR__ . '/../models/AvisModel.php';
require_once __DIR__ . '/../models/HoraireModel.php';



class HomeController{

    private AvisModel $avis;

    private HoraireModel $horaire;

    public function __construct(){
        $this->avis = new AvisModel();
        $this->horaire = new HoraireModel();
    }

    public function showLanding(){
        $avis = $this->avis->getAvis('valide');
        $horaire = $this->horaire->getHoraire();
        require_once __DIR__ . '/../views/index.php';
    }

    public function showMentions(){
        $horaire = $this->horaire->getHoraire();
        require_once __DIR__ . '/../views/mentionsLegales.php';
    }

    public function showCgv(){
        $horaire = $this->horaire->getHoraire();
        require_once __DIR__ . '/../views/cgv.php';
    }

    public function showConfidentialite(){
        $horaire = $this->horaire->getHoraire();
        require_once __DIR__ . '/../views/confidentialite.php';
    }

}