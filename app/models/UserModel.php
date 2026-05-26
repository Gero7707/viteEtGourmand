<?php
require_once __DIR__ . '/../../core/Database.php';


class UserModel{
    private $pdo;

    public function __construct(){
        $this->pdo = Database::getInstance()->getConnection();
    }

    public function findByEmail(string $email){
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email ");
        $stmt->bindValue(':email', $email , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createUser(array $data){
        $stmt = $this->pdo->prepare("INSERT INTO users (email, pseudo, password, role) VALUES (:email, :pseudo, :password, :role)");
        $stmt->bindValue(':email', $data['email'], PDO::PARAM_STR);
        $stmt->bindValue(':pseudo', $data['pseudo'], PDO::PARAM_STR);
        $stmt->bindValue(':password', $data['password'], PDO::PARAM_STR);
        $stmt->bindValue(':role', $data['role'], PDO::PARAM_STR);
        $stmt->execute();
        return $this->pdo->lastInsertId();
    }

    public function findByPseudo(string $pseudo){
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE pseudo = :pseudo");
        $stmt->bindValue(':pseudo', $pseudo , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllUsers(){
        $stmt = $this->pdo->prepare("SELECT * FROM users");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function saveResetToken(string $email,string $token,string $expires){
        $stmt = $this->pdo->prepare("UPDATE users SET reset_token = :reset_token  , reset_token_expires_at = :reset_token_expires_at WHERE email = :email");
        $stmt->bindValue(':reset_token', $token , PDO::PARAM_STR);
        $stmt->bindValue(':reset_token_expires_at' , $expires , PDO::PARAM_STR);
        $stmt->bindValue(':email' , $email, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function findByResetToken(string $token){
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE reset_token = :reset_token");
        $stmt->bindValue(':reset_token', $token , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updatePassword(int $id, string $hashedPassword){
        $stmt =$this->pdo->prepare("UPDATE  users  SET password = :password WHERE id = :id");
        $stmt->bindValue(':id' , $id , PDO::PARAM_INT);
        $stmt->bindValue(':password' , $hashedPassword , PDO::PARAM_STR);
        return $stmt->execute();
    }
    
    public function clearResetToken(int $id){
        $stmt = $this->pdo->prepare("UPDATE users SET reset_token = null , reset_token_expires_at = null WHERE id = :id");
        $stmt-> bindValue(':id' , $id , PDO::PARAM_INT);
        return $stmt->execute();
    }
}