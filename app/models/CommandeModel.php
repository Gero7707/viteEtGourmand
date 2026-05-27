<?php
require_once __DIR__ . '/../../core/Database.php';


class CommandeModel{
    private $pdo;

    public function __construct(){
        $this->pdo = Database::getInstance()->getConnection();
    }

    public function getCommandes(int $id){
        $stmt = $this->pdo->prepare("SELECT  commande.* , menu.titre AS titre 
                                    FROM commande
                                    JOIN menu ON commande.menu_id = menu.menu_id
                                    WHERE commande.utilisateur_id = :id
                                    ");
        $stmt->bindValue(':id', $id , PDO::PARAM_INT);   
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}