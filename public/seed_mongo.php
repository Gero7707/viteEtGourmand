<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../core/MongoDatabase.php';

$collection = MongoDatabase::getInstance()->getCollection('commandes');

$menus = [
    1 => ['titre' => 'Menu Prestige', 'prix_par_personne' => 45],
    2 => ['titre' => 'Menu Réveillon', 'prix_par_personne' => 55],
    3 => ['titre' => 'Menu Brunch de Pâques', 'prix_par_personne' => 30],
    4 => ['titre' => 'Menu Brunch Estival', 'prix_par_personne' => 28],
    5 => ['titre' => 'Menu Jardin d\'Été', 'prix_par_personne' => 35],
    6 => ['titre' => 'Menu Champêtre', 'prix_par_personne' => 32],
    7 => ['titre' => 'Menu Féérie d\'Hiver', 'prix_par_personne' => 42]
];

$months = ['2026-01', '2026-02', '2026-03', '2026-04', '2026-05'];

foreach($months as $month){
    for($i = 0; $i < 25; $i++){
        $menu_id = array_rand($menus);
        $date_terminee = $month . '-' . str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT) . ' 10:00:00';
        $nb_personnes = rand(12, 30);
        $prix_total = $nb_personnes * $menus[$menu_id]['prix_par_personne'];

        $data = [
            'commande_id'  => null,
            'menu_id'      => $menu_id,
            'menu_titre'   => $menus[$menu_id]['titre'],
            'prix_total'   =>$prix_total,
            'date_terminee' => $date_terminee
        ];
        $collection->insertOne($data);
    }
    
}
echo "Données créées et insérées — " . (count($months) * 25) . " documents insérés.";