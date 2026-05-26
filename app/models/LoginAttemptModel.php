<?php

require_once __DIR__ . '/../../core/Database.php';

class LoginAttemptModel{
    private object  $pdo;

    public function __construct(){
        $this->pdo = Database::getInstance()->getConnection();
    }

    public function getAttempts(string $ip, string $email){
        $stmt = $this->pdo->prepare("SELECT * FROM login_attempts 
                                    WHERE ip = :ip AND email = :email 
                                    AND attempted_at > (NOW() - INTERVAL 15 MINUTE)");
        $stmt->bindValue(':ip', $ip , PDO::PARAM_STR );
        $stmt->bindValue(':email', $email , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addAttempt(string $ip, string $email){
        $stmt = $this->pdo->prepare("INSERT INTO login_attempts(ip , email, attempts) 
                                    VALUES(:ip , :email, 1)
                                    ON DUPLICATE KEY UPDATE attempts = attempts + 1");
        $stmt->bindValue(':ip' , $ip , PDO::PARAM_STR);
        $stmt->bindValue(':email' , $email , PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function resetAttempts(string $ip, string $email){
        $stmt = $this->pdo->prepare("DELETE FROM login_attempts WHERE ip = :ip AND email = :email");
        $stmt->bindValue(':ip' , $ip , PDO::PARAM_STR);
        $stmt->bindValue(':email' , $email , PDO::PARAM_STR);
        return $stmt->execute();
    }
}