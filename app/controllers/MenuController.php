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
}