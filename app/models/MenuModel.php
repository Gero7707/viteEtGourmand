<?php
require_once __DIR__ . '/../../core/Database.php';

class MenuModel{
    private PDO $pdo;

    public function __construct(){
        $this->pdo = Database::getInstance()->getConnection();
    }

    public function index(){
        $stmt = $this->pdo->query("SELECT menu.* , regime.libelle AS regime , theme.libelle AS theme, image_menu.chemin AS image 
                                    FROM menu
                                    JOIN regime ON menu.regime_id = regime.regime_id
                                    JOIN theme ON menu.theme_id = theme.theme_id
                                    LEFT JOIN image_menu ON image_menu.menu_id = menu.menu_id
                                    ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOneMenu(){
        $stmt = $this->pdo->query("SELECT menu.* FROM menu LIMIT 1");
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findById(int $id){
        $stmt = $this->pdo->prepare("SELECT menu.* , regime.libelle AS regime , theme.libelle AS theme , image_menu.chemin AS chemin
                                    FROM menu 
                                    JOIN regime ON menu.regime_id = regime.regime_id
                                    JOIN theme ON menu.theme_id = theme.theme_id
                                    LEFT JOIN image_menu ON  image_menu.menu_id = menu.menu_id 
                                    WHERE menu.menu_id = :menu_id ");
        $stmt->bindValue(':menu_id', $id , PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getMenuPlats(int $menu_id){
        $stmt = $this->pdo-> prepare("SELECT plat.*
                                    FROM menu_plat
                                    JOIN plat ON menu_plat.plat_id = plat.plat_id
                                    WHERE menu_plat.menu_id = :menu_id 
                                    ");
        $stmt->bindValue(':menu_id', $menu_id , PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
                                    JOIN menu_plat ON plat.plat_id = menu_plat.plat_id
                                    JOIN menu ON menu_plat.menu_id = menu.menu_id
                                    ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createMenu(array $data){
        $stmt =$this->pdo->prepare("INSERT INTO menu (titre , nombre_personne_minimum , prix_par_personne , description , quantite_restante , conditions_delai , conditions_stockage , conditions_infos , theme_id , regime_id)
                                    VALUES (:titre , :nombre_personne_minimum , :prix_par_personne , :description , :quantite_restante , :conditions_delai , :conditions_stockage , :conditions_infos , :theme_id , :regime_id)
                                    ");
        $stmt->bindValue(':titre', $data['titre'], PDO::PARAM_STR);                           
        $stmt->bindValue(':nombre_personne_minimum', $data['nombre_personne_minimum'], PDO::PARAM_INT);                           
        $stmt->bindValue(':prix_par_personne', $data['prix_par_personne'], PDO::PARAM_STR);                           
        $stmt->bindValue(':description', $data['description'], PDO::PARAM_STR);                           
        $stmt->bindValue(':quantite_restante', $data['quantite_restante'], $data['quantite_restante'] === null ? PDO::PARAM_NULL : PDO::PARAM_INT);                          
        $stmt->bindValue(':conditions_delai', $data['conditions_delai'], PDO::PARAM_STR);                           
        $stmt->bindValue(':conditions_stockage', $data['conditions_stockage'], PDO::PARAM_STR);                           
        $stmt->bindValue(':conditions_infos', $data['conditions_infos'], PDO::PARAM_STR);
        $stmt->bindValue(':regime_id', $data['regime_id'], PDO::PARAM_INT);                             
        $stmt->bindValue(':theme_id', $data['theme_id'], PDO::PARAM_INT);
        $stmt->execute();
        return $this->pdo->lastInsertId();
    }

    public function addImageMenu(array $data){
        $stmt = $this->pdo->prepare("INSERT INTO image_menu (chemin , menu_id) VALUES (:chemin , :menu_id)");
        $stmt->bindValue(':chemin', $data['chemin'], PDO::PARAM_STR);                           
        $stmt->bindValue(':menu_id', $data['menu_id'], PDO::PARAM_INT);  
        $stmt->execute();
    }

    public function updateMenu(array $data){
        $stmt =$this-> pdo->prepare("UPDATE menu SET titre = :titre , nombre_personne_minimum  = :nombre_personne_minimum, prix_par_personne = :prix_par_personne , description = :description , quantite_restante = :quantite_restante, conditions_delai = :conditions_delai, conditions_stockage = :conditions_stockage, conditions_infos = :conditions_infos, theme_id = :theme_id , regime_id = :regime_id  WHERE menu_id = :menu_id");
        $stmt->bindValue(':menu_id', $data['menu_id'] , PDO::PARAM_INT);
        $stmt->bindValue(':titre', $data['titre'], PDO::PARAM_STR);                           
        $stmt->bindValue(':nombre_personne_minimum', $data['nombre_personne_minimum'], PDO::PARAM_INT);                           
        $stmt->bindValue(':prix_par_personne', $data['prix_par_personne'], PDO::PARAM_STR);                           
        $stmt->bindValue(':description', $data['description'], PDO::PARAM_STR);                           
        $stmt->bindValue(':quantite_restante', $data['quantite_restante'], $data['quantite_restante'] === null ? PDO::PARAM_NULL : PDO::PARAM_INT);                          
        $stmt->bindValue(':conditions_delai', $data['conditions_delai'], PDO::PARAM_STR);                           
        $stmt->bindValue(':conditions_stockage', $data['conditions_stockage'], PDO::PARAM_STR);                           
        $stmt->bindValue(':conditions_infos', $data['conditions_infos'], PDO::PARAM_STR);
        $stmt->bindValue(':regime_id', $data['regime_id'], PDO::PARAM_INT);                             
        $stmt->bindValue(':theme_id', $data['theme_id'], PDO::PARAM_INT);
        $stmt->execute();
    }

    public function deleteImage(int $id){
        $stmt = $this->pdo->prepare("DELETE FROM image_menu WHERE menu_id = :id");
        $stmt->bindValue(':id', $id , PDO::PARAM_INT);
        $stmt->execute();
    }
}