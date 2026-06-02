<?php
require_once __DIR__ . '/../../core/Database.php';


class HoraireModel{
    private $pdo;

    public function __construct(){
        $this->pdo = Database::getInstance()->getConnection();
    }

    public function getHoraire(){
        $stmt = $this->pdo->prepare("SELECT jour , DATE_FORMAT(heure_ouverture, '%Hh%i') AS heure_ouverture, DATE_FORMAT(heure_fermeture, '%Hh%i') AS heure_fermeture FROM horaire ORDER BY FIELD(jour, 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche')");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getHoraireRaw(){
        $stmt = $this->pdo->query("SELECT jour , heure_ouverture ,heure_fermeture ,horaire_id FROM horaire ORDER BY FIELD(jour, 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche')");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateHoraire(int $id,string $heureOuverture,string $heureFermeture){
        $stmt = $this->pdo->prepare("UPDATE horaire set heure_ouverture = :heure_ouverture , heure_fermeture = :heure_fermeture WHERE horaire_id = :id");
        $stmt->bindValue(':heure_ouverture', $heureOuverture , PDO::PARAM_STR);
        $stmt->bindValue(':heure_fermeture', $heureFermeture , PDO::PARAM_STR);
        $stmt->bindValue(':id', $id , PDO::PARAM_INT);
        $stmt->execute();
    }

    public function ajouterJour(array $data){
        $stmt = $this->pdo->prepare("INSERT INTO horaire (jour , heure_ouverture , heure_fermeture) VALUES (:jour , :heure_ouverture , :heure_fermeture )");
        $stmt->bindValue(':jour' , $data['jour'] , PDO::PARAM_STR);
        $stmt->bindValue(':heure_ouverture' , $data['heure_ouverture'] , PDO::PARAM_STR);
        $stmt->bindValue(':heure_fermeture' , $data['heure_fermeture'] , PDO::PARAM_STR);
        $stmt->execute();
    }

    public function supprimerJour(int $id){
        $stmt = $this->pdo->prepare("DELETE FROM horaire WHERE horaire_id = :id");
        $stmt->bindValue(':id', $id , PDO::PARAM_INT);
        $stmt->execute();
    }
}