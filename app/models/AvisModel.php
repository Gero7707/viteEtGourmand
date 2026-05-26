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
}