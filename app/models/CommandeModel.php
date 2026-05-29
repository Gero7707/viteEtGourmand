<?php
require_once __DIR__ . '/../../core/Database.php';


class CommandeModel{
    private PDO $pdo;

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

    public function getAllCommandes(){
        $stmt = $this->pdo->query("SELECT commande.* , menu.titre AS titre , CONCAT(utilisateur.prenom , ' ' , utilisateur.nom) as nom_complet
                                    FROM commande
                                    JOIN menu ON commande.menu_id = menu.menu_id
                                    JOIN utilisateur ON commande.utilisateur_id = utilisateur.utilisateur_id
                                    ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById(int $id){
        $stmt =$this->pdo->prepare("SELECT commande.* , 
                                    menu.titre AS titre ,
                                    CONCAT(utilisateur.prenom , ' ' , utilisateur.nom) as nom_complet,
                                    utilisateur.ville ,
                                    utilisateur.adresse,
                                    utilisateur.code_postal,
                                    utilisateur.email,
                                    utilisateur.gsm
                                    FROM commande
                                    JOIN menu ON commande.menu_id = menu.menu_id
                                    JOIN utilisateur ON commande.utilisateur_id = utilisateur.utilisateur_id
                                    WHERE commande.commande_id = :id
                                ");
        $stmt->bindValue(':id', $id , PDO::PARAM_INT);   
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getHistorique(int $id){
        $stmt = $this->pdo->prepare("SELECT * FROM historique_statut WHERE commande_id = :id ORDER BY date_modification");
        $stmt->bindValue(':id', $id , PDO::PARAM_INT);   
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);                            
    }

    public function createCommande(array $data){
        $stmt = $this->pdo->prepare("INSERT INTO commande (adresse_livraison , distance_km , numero_commande , date_commande , date_prestation , heure_livraison , prix_menu , nombre_personne , prix_livraison , statut , pret_materiel , utilisateur_id , menu_id )
                                    VALUES (:adresse_livraison , :distance_km , :numero_commande , :date_commande , :date_prestation , :heure_livraison , :prix_menu , :nombre_personne , :prix_livraison , :statut , :pret_materiel ,  :utilisateur_id , :menu_id )");
        $stmt->bindValue(':adresse_livraison', $data['adresse_livraison'], PDO::PARAM_STR);
        $stmt->bindValue(':distance_km', $data['distance_km'], PDO::PARAM_STR);
        $stmt->bindValue(':numero_commande', $data['numero_commande'], PDO::PARAM_STR);
        $stmt->bindValue(':date_commande', $data['date_commande'], PDO::PARAM_STR);
        $stmt->bindValue(':date_prestation', $data['date_prestation'], PDO::PARAM_STR);
        $stmt->bindValue(':heure_livraison', $data['heure_livraison'], PDO::PARAM_STR);
        $stmt->bindValue(':prix_menu', $data['prix_menu'], PDO::PARAM_STR);
        $stmt->bindValue(':nombre_personne', $data['nombre_personne'], PDO::PARAM_INT);
        $stmt->bindValue(':prix_livraison', $data['prix_livraison'], PDO::PARAM_STR);
        $stmt->bindValue(':statut', $data['statut'], PDO::PARAM_STR);
        $stmt->bindValue(':pret_materiel', $data['pret_materiel'], PDO::PARAM_INT);
        $stmt->bindValue(':menu_id', $data['menu_id'], PDO::PARAM_INT);
        $stmt->bindValue(':utilisateur_id', $data['utilisateur_id'], PDO::PARAM_INT);
        $stmt->execute();
        return $this->pdo->lastInsertId();
    }

    public function createHistorique(array $data) : void{
        $stmt = $this->pdo->prepare("INSERT INTO historique_statut (statut , date_modification , commande_id) VALUES (:statut , :date_modification , :commande_id)");
        $stmt->bindValue(':statut', $data['statut'], PDO::PARAM_STR);
        $stmt->bindValue(':date_modification', $data['date_modification'], PDO::PARAM_STR);
        $stmt->bindValue(':commande_id', $data['commande_id'], PDO::PARAM_INT);
        $stmt->execute();
    }
}