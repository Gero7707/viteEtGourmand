<?php
require_once __DIR__ . '/../../core/Database.php';

class AllergeneModel{
    private PDO $pdo;

    public function __construct(){
        $this->pdo = Database::getInstance()->getConnection();
    }

    public function getAll(){
        $stmt = $this->pdo->query("SELECT allergene.* FROM allergene ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}