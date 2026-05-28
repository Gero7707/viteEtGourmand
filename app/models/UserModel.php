<?php
require_once __DIR__ . '/../../core/Database.php';


class UserModel{
    private PDO $pdo;

    public function __construct(){
        $this->pdo = Database::getInstance()->getConnection();
    }

    public function findByEmail(string $email){
        $stmt = $this->pdo->prepare("SELECT * FROM utilisateur WHERE email = :email ");
        $stmt->bindValue(':email', $email , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findById(int $id){
        $stmt = $this->pdo->prepare("SELECT * FROM utilisateur WHERE utilisateur_id = :id");
        $stmt->bindValue(':id' , $id , PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createUser(array $data){
        $stmt = $this->pdo->prepare("INSERT INTO utilisateur (email, password,nom , prenom ,role_id) VALUES (:email, :password, :nom , :prenom , :role_id)");
        $stmt->bindValue(':email', $data['email'], PDO::PARAM_STR);
        $stmt->bindValue(':password', $data['password'], PDO::PARAM_STR);
        $stmt->bindValue(':nom', $data['nom'], PDO::PARAM_STR);
        $stmt->bindValue(':prenom', $data['prenom'], PDO::PARAM_STR);
        $stmt->bindValue(':role_id', $data['role_id'], PDO::PARAM_INT);
        $stmt->execute();
        return $this->pdo->lastInsertId();
    }


    public function getAllUsers(){
        $stmt = $this->pdo->prepare("SELECT * FROM utilisateur");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getEmploye(){
        $stmt = $this->pdo->query("SELECT email , nom , prenom , gsm , ville , actif 
                                    FROM utilisateur
                                    WHERE role_id = 2
                                    ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function saveResetToken(string $email,string $token,string $expires){
        $stmt = $this->pdo->prepare("UPDATE utilisateur SET reset_token = :reset_token  , reset_token_expires_at = :reset_token_expires_at WHERE email = :email");
        $stmt->bindValue(':reset_token', $token , PDO::PARAM_STR);
        $stmt->bindValue(':reset_token_expires_at' , $expires , PDO::PARAM_STR);
        $stmt->bindValue(':email' , $email, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function findByResetToken(string $token){
        $stmt = $this->pdo->prepare("SELECT * FROM utilisateur WHERE reset_token = :reset_token");
        $stmt->bindValue(':reset_token', $token , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updatePassword(int $id, string $hashedPassword){
        $stmt =$this->pdo->prepare("UPDATE  utilisateur  SET password = :password WHERE utilisateur_id = :id");
        $stmt->bindValue(':id' , $id , PDO::PARAM_INT);
        $stmt->bindValue(':password' , $hashedPassword , PDO::PARAM_STR);
        return $stmt->execute();
    }
    
    public function clearResetToken(int $id){
        $stmt = $this->pdo->prepare("UPDATE utilisateur SET reset_token = null , reset_token_expires_at = null WHERE utilisateur_id = :id");
        $stmt-> bindValue(':id' , $id , PDO::PARAM_INT);
        return $stmt->execute();
    }
}