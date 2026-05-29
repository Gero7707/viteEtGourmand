<?php
require_once __DIR__ . '/../models/CommandeModel.php';
require_once __DIR__ . '/../models/HoraireModel.php';
require_once __DIR__ . '/../models/MenuModel.php';

class CommandeController{
    private HoraireModel $horaire;
    private CommandeModel $commandes;

    private MenuModel $menu;

    public function __construct(){
        $this->commandes = new CommandeModel();
        $this->horaire = new HoraireModel();
        $this->menu = new MenuModel();
    }

    public function showCommandes(){
        $id = $_SESSION['utilisateur_id'];
        $commandes = $this->commandes->getCommandes($id);
        $horaire = $this->horaire->getHoraire();
        require_once __DIR__ . '/../views/commande/commandeListe.php';
    }

    public function showAllCommandes(){
        $horaire = $this->horaire->getHoraire();
        $commandes = $this->commandes->getAllCommandes();
        require_once __DIR__ . '/../views/employe/commandesClient.php';
    }

    public function show(int $id){
        $horaire = $this->horaire->getHoraire();
        $commandes = $this->commandes->findById($id);
        $historique = $this->commandes->getHistorique($id);
        require_once __DIR__ . '/../views/commande/userCommande.php';
    }

    public function showForm(int $menu_id){
        Auth::checkAuth();
        $horaire = $this->horaire->getHoraire();
        $menu = $this->menu->findById($menu_id);
        $data = [
            'email' => $_SESSION['email'],
            'nom' => $_SESSION['nom'],
            'prenom' => $_SESSION['prenom'],
            'adresse' => $_SESSION['adresse'] ?? '' ,
            'ville' => $_SESSION['ville'] ?? '' ,
            'code_postal' => $_SESSION['code_postal'] ?? '' 
        ];
        require_once __DIR__ . '/../views/commande/commandeForm.php';
    }
}