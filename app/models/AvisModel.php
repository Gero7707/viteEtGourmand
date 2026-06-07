<?php
require_once __DIR__ . '/../../core/Database.php';

class AvisModel{
    private $pdo;

    public function __construct(){
        $this->pdo = Database::getInstance()->getConnection();
    }

    public function getAvis(string $statut){
        $stmt = $this->pdo->prepare("SELECT avis.avis_id,
                                    avis.note, 
                                    avis.description , 
                                    avis.date_avis, 
                                    avis.utilisateur_id, 
                                    CONCAT(utilisateur.prenom , ' ' , utilisateur.nom) as nom_complet
                                    FROM avis 
                                    JOIN utilisateur ON avis.utilisateur_id = utilisateur.utilisateur_id
                                    WHERE statut = :statut ");
        $stmt->bindValue(':statut', $statut , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAvisByCommandeId(int $id){
        $stmt = $this->pdo->prepare("SELECT avis.* from avis WHERE commande_id = :id");
        $stmt->bindValue(':id' , $id , PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function noterCommande(array $data){
        $stmt = $this->pdo->prepare("INSERT INTO avis(note , description , statut , date_avis , commande_id , utilisateur_id) VALUES (:note , :description , :statut , :date_avis , :commande_id , :utilisateur_id) ");
        $stmt->bindValue(':note', $data['note'], PDO::PARAM_INT);
        $stmt->bindValue(':description', $data['description'], PDO::PARAM_STR);
        $stmt->bindValue(':statut', $data['statut'], PDO::PARAM_STR);
        $stmt->bindValue(':date_avis', $data['date_avis'], PDO::PARAM_STR);
        $stmt->bindValue(':commande_id', $data['commande_id'], PDO::PARAM_INT);
        $stmt->bindValue(':utilisateur_id', $data['utilisateur_id'], PDO::PARAM_INT);
        $stmt->execute();
    }

    public function findByCommandeId(int $commande_id ){
        $stmt = $this->pdo->prepare("SELECT avis.* FROM avis WHERE commande_id = :id");
        $stmt->bindValue(':id', $commande_id  , PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findById(int $id){
        $stmt = $this->pdo->prepare("SELECT avis.* FROM avis WHERE avis_id = :id");
        $stmt->bindValue(':id', $id  , PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateAvis(array $data){
        $stmt = $this->pdo->prepare("UPDATE avis SET note = :note , description = :description , statut = :statut ,date_avis = :date_avis WHERE avis_id = :id");
        $stmt->bindValue(':id', $data['avis_id'], PDO::PARAM_INT);
        $stmt->bindValue(':note', $data['note'], PDO::PARAM_INT);
        $stmt->bindValue(':description', $data['description'], PDO::PARAM_STR);
        $stmt->bindValue(':statut', $data['statut'], PDO::PARAM_STR);
        $stmt->bindValue(':date_avis', $data['date_avis'], PDO::PARAM_STR);
        $stmt->execute();
    }

    public function changeStatut(array $data){
        $stmt = $this->pdo->prepare("UPDATE avis SET statut = :statut WHERE avis_id = :id");
        $stmt->bindValue(':id', $data['avis_id'], PDO::PARAM_INT);
        $stmt->bindValue(':statut', $data['statut'], PDO::PARAM_STR);
        $stmt->execute();
    }
}