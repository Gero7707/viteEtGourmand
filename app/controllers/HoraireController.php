<?php
require_once __DIR__ . '/../models/HoraireModel.php';


class HoraireController{
    private HoraireModel $horaires;

    public function __construct(){
        $this->horaires = new HoraireModel();
    }

    public function showFormHoraire(){
        Auth::checkEmploye();
        $id = $_SESSION['utilisateur_id'];
        $horaires = $this->horaires->getHoraireRaw();
        require_once __DIR__ . '/../views/employe/changerHoraire.php';
    }
    public function updateHoraire(){
        Auth::checkEmploye();
        Auth::verifyCsrfToken();
        foreach($_POST['heure_ouverture'] as $id => $heureOuverture){
            $heureFermeture = $_POST['heure_fermeture'][$id];
            $this->horaires->updateHoraire($id, $heureOuverture, $heureFermeture);
        }
        
        $successMessage = "Les horaires ont été mis à jour avec succès.";
        header('Location: /changer-horaire?success=' . urlencode($successMessage));
        exit();
    }
}