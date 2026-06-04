<?php
require_once __DIR__ . '/../../core/Database.php';

class PlatModel{
    private PDO $pdo;

    public function __construct(){
        $this->pdo = Database::getInstance()->getConnection();
    }

    public function getPlatAllergenes(int $plat_id){
        $stmt = $this->pdo->prepare("SELECT allergene.*
                                    FROM plat_allergene
                                    JOIN allergene ON plat_allergene.allergene_id = allergene.allergene_id
                                    WHERE plat_allergene.plat_id = :plat_id
                                    ");
        $stmt->bindValue(':plat_id', $plat_id , PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllPlats(){
        $stmt = $this->pdo->query("SELECT plat.*, menu.titre AS menu_titre
                                    FROM plat
                                    LEFT JOIN menu_plat ON plat.plat_id = menu_plat.plat_id
                                    LEFT JOIN menu ON menu_plat.menu_id = menu.menu_id
                                    ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPlatById(int $id){
        $stmt = $this->pdo->prepare("SELECT plat.* FROM plat WHERE plat_id = :plat_id");
        $stmt->bindValue(':plat_id', $id , PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createPlat(array $data){
        $stmt = $this->pdo->prepare("INSERT INTO plat (titre_plat , type_plat , chemin_photo) VALUES (:titre_plat , :type_plat , :chemin_photo)");
        $stmt->bindValue(':titre_plat' , $data['titre_plat'] ,PDO::PARAM_STR );
        $stmt->bindValue(':type_plat' , $data['type_plat'] ,PDO::PARAM_STR );
        $stmt->bindValue(':chemin_photo' , $data['chemin_photo'] ,PDO::PARAM_STR );
        $stmt->execute();
        return $this->pdo->lastInsertId();
    }
    public function platLinkAllergene(int $platId, int $allergene_id){
        $stmt = $this->pdo->prepare("INSERT INTO plat_allergene (plat_id , allergene_id) VALUES (:plat_id , :allergene_id)");
        $stmt->bindValue(':allergene_id' , $allergene_id ,PDO::PARAM_INT );
        $stmt->bindValue(':plat_id' , $platId ,PDO::PARAM_INT );
        $stmt->execute();
    }

    public function associerPlat(int $id , int $menu_id){
        $stmt = $this->pdo->prepare("INSERT INTO menu_plat (menu_id , plat_id) VALUES (:menu_id , :plat_id)");
        $stmt->bindValue(':plat_id' , $id ,PDO::PARAM_INT );
        $stmt->bindValue(':menu_id' , $menu_id ,PDO::PARAM_INT );
        $stmt->execute();
    }

    public function dissocierPlat(int $id){
        $stmt = $this->pdo->prepare("DELETE FROM menu_plat WHERE plat_id = :id");
        $stmt->bindValue(':id' , $id ,PDO::PARAM_INT );
        $stmt->execute();
    }

    public function updatePlat(array $data){
        if(isset($data['chemin_photo'])){
            $stmt = $this->pdo->prepare("UPDATE plat SET titre_plat = :titre_plat , type_plat = :type_plat , chemin_photo = :chemin_photo WHERE plat_id = :plat_id");
            $stmt->bindValue(':plat_id' , $data['plat_id'] ,PDO::PARAM_INT );
            $stmt->bindValue(':titre_plat' , $data['titre_plat'] ,PDO::PARAM_STR );
            $stmt->bindValue(':type_plat' , $data['type_plat'] ,PDO::PARAM_STR );
            $stmt->bindValue(':chemin_photo' , $data['chemin_photo'] ,PDO::PARAM_STR );
        }else{
            $stmt = $this->pdo->prepare("UPDATE plat SET titre_plat = :titre_plat , type_plat = :type_plat  WHERE plat_id = :plat_id");
            $stmt->bindValue(':plat_id' , $data['plat_id'] ,PDO::PARAM_INT );
            $stmt->bindValue(':titre_plat' , $data['titre_plat'] ,PDO::PARAM_STR );
            $stmt->bindValue(':type_plat' , $data['type_plat'] ,PDO::PARAM_STR );
        }
        $stmt->execute();
    }

    
    public function deleteAllergeneLink(int $plat_id){
        $stmt = $this->pdo->prepare("DELETE FROM plat_allergene WHERE plat_id = :plat_id");
        $stmt->bindValue(':plat_id', $plat_id , PDO::PARAM_INT);
        $stmt->execute();
    }

    public function deleteImage(int $id){
        $stmt = $this->pdo->prepare("UPDATE plat SET chemin_photo = NULL WHERE plat_id = :plat_id");
        $stmt->bindValue(':plat_id', $id , PDO::PARAM_INT);
        $stmt->execute();
    }

    public function PlatLinkCommande(int $plat_id){
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM commande 
                                    JOIN menu_plat ON commande.menu_id = menu_plat.menu_id 
                                    WHERE menu_plat.plat_id = :plat_id 
                                    AND commande.statut NOT IN ('terminee', 'annulee')
                                    ");
        $stmt->bindValue(':plat_id', $plat_id , PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function deletePlat(int $id){
        $stmt = $this->pdo->prepare("DELETE FROM plat WHERE plat_id = :plat_id");
        $stmt->bindValue(':plat_id' , $id ,PDO::PARAM_INT );
        $stmt->execute();
    }

    public function deleteMenuPlatLink(int $plat_id){
        $stmt = $this->pdo->prepare("DELETE FROM menu_plat WHERE plat_id = :plat_id");
        $stmt->bindValue(':plat_id', $plat_id , PDO::PARAM_INT);
        $stmt->execute();
    }

    public function getMenusDisponibles(int $plat_id){
        $stmt = $this->pdo->prepare("SELECT menu.* FROM menu 
                                    WHERE menu.menu_id NOT IN (
                                        SELECT menu_plat.menu_id FROM menu_plat 
                                        JOIN plat ON menu_plat.plat_id = plat.plat_id
                                        WHERE plat.type_plat = (SELECT type_plat FROM plat WHERE plat_id = :plat_id)
                                    )");
        $stmt->bindValue(':plat_id', $plat_id , PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}