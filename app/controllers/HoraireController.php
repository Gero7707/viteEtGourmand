<?php
require_once __DIR__ . '/../models/HoraireModel.php';


class HoraireController{
    private HoraireModel $horaires;

    public function __construct(){
        $this->horaires = new HoraireModel();
    }

    public function showFormHoraire(){
        Auth::checkEmploye();
        $horaires = $this->horaires->getHoraireRaw();

        $jours = ['Lundi' , 'Mardi' , 'Mercredi' , 'Jeudi' , 'Vendredi' , 'Samedi' , 'Dimanche'];
        $joursEnBase = array_column($horaires, 'jour');
        $jourManquants = array_diff($jours, $joursEnBase);

        require_once __DIR__ . '/../views/employe/changerHoraire.php';
    }
    public function updateHoraire(){
        Auth::checkEmploye();
        Auth::verifyCsrfToken();
        $data = [];
        foreach($_POST['heure_ouverture'] as $id => $heureOuverture){
            $heureFermeture = $_POST['heure_fermeture'][$id];
            $this->horaires->updateHoraire($id, $heureOuverture, $heureFermeture);
        }
        
        $successMessage = "Les horaires ont été mis à jour avec succès.";
        header('Location: /changer-horaire?success=' . urlencode($successMessage));
        exit();
    }

    public function ajouterJour(){
        Auth::checkEmploye();
        Auth::verifyCsrfToken();
        foreach($_POST['heure_ouverture'] as $jour => $heureOuverture){
            $heureFermeture = $_POST['heure_fermeture'][$jour];
            $data = ['jour' => $jour ,
                    'heure_ouverture' => $heureOuverture,
                    'heure_fermeture' => $heureFermeture
            ];
            $this->horaires->ajouterJour($data);
        }

        $successMessage = "Le jour a été ajouté avec succès.";
        header('Location: /changer-horaire?success=' . urlencode($successMessage));
        exit();
    }

    public function supprimerJour(int $id){
        Auth::checkEmploye();
        Auth::verifyCsrfToken();
        $this->horaires->supprimerJour($id);
        $successMessage = "Le jour a été supprimé avec succès .";
        header('Location: /changer-horaire?success=' . urlencode($successMessage));
        exit();
    }
}