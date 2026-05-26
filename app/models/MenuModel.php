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
}