<?php
require_once __DIR__ . '/../models/MenuModel.php';
require_once __DIR__ . '/../models/HoraireModel.php';

class MenuController{
    private MenuModel $menus;

    private HoraireModel $horaire;

    public function __construct(){
        $this->menus = new MenuModel();
        $this->horaire = new HoraireModel();
    }

    public function index(){
        $menus = $this->menus->index();
        $horaire = $this->horaire->getHoraire();
        require_once __DIR__ . '/../views/menus/menus.php';
    }

    public function show(int $id){
        $horaire = $this->horaire->getHoraire();
        $menus = $this->menus->findById($id);
        $plat = $this->menus->getMenuPlats($id);
        // Pour chaque plat, on récupère ses allergènes et on les attache au plat
        // Le & permet de modifier directement le tableau $plat (passage par référence)
        foreach($plat as &$p) {
            $p['allergenes'] = $this->menus->getPlatAllergenes($p['plat_id']);
        }
        unset($p); // Casse la référence pour éviter le bug variable de référence reste liée au dernier élément du tableau après la boucle
        require_once __DIR__ . '/../views/menus/carteMenu.php';
    }

    public function showAllPlats(){
        $horaire = $this->horaire->getHoraire();
        $plat = $this->menus->getAllPlats();
        foreach($plat as &$p) {
            $p['allergenes'] = $this->menus->getPlatAllergenes($p['plat_id']);
        }
        unset($p);
        require_once __DIR__ . '/../views/employe/plats.php';
    }
}