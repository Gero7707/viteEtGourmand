<?php
require_once __DIR__ . '/../../core/Database.php';


class HoraireModel{
    private $pdo;

    public function __construct(){
        $this->pdo = Database::getInstance()->getConnection();
    }

    public function getHoraire(){
        $stmt = $this->pdo->prepare("SELECT * FROM horaire ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}