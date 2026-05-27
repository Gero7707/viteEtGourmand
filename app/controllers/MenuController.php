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
        $menus = $this->menus->findById($id);
        $plat = $this->menus->getMenuPlats($id);
        // Pour chaque plat, on récupère ses allergènes et on les attache au plat
        // Le & permet de modifier directement le tableau $plat (passage par référence)
        foreach($plat as &$p) {
            $p['allergenes'] = $this->menus->getPlatAllergenes($p['plat_id']);
        }
        require_once __DIR__ . '/../views/menus/carteMenu.php';
    }
}