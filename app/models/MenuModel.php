<?php
require_once __DIR__ . '/../../core/Database.php';

class MenuModel{
    private $pdo;

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

    public function findById(int $id){
        $stmt = $this->pdo->prepare("SELECT menu.* , regime.libelle AS regime , theme.libelle AS theme 
                                    FROM menu 
                                    JOIN regime ON menu.regime_id = regime.regime_id
                                    JOIN theme ON menu.theme_id = theme.theme_id
                                    WHERE menu_id = :menu_id ");
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
}