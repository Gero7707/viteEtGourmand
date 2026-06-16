<?php
require_once __DIR__ . '/../../core/MongoDatabase.php';

class MongoModel{
    

    public function insertCommande(array $data): void {
        $collection = MongoDatabase::getInstance()->getCollection('commandes');
        $collection->insertOne($data);
    }


    public function getCommandesParMenu(): array{
        $collection = MongoDatabase::getInstance()->getCollection('commandes');
        $cursor = $collection->aggregate([
            ['$group' => [
                '_id'   => '$menu_titre',  // regrouper par menu_titre
                'total' => ['$sum' => 1]   // compter +1 par document
            ]],
            ['$sort' => ['total' => -1]]   // trier du plus commandé au moins commandé et 1 fera l'inverse
        ]);
        return $cursor->toArray();
    }

    public function getCAParMenu(array $filtres): array
{
        $collection = MongoDatabase::getInstance()->getCollection('commandes');
        
        // On construit le pipeline dynamiquement
        $pipeline = [];
        
        // Étape 1 : $match — on filtre seulement si des filtres sont fournis
        $match = [];
        if (!empty($filtres['menu'])) {
            $match['menu_titre'] = $filtres['menu'];
        }
        if (!empty($filtres['mois'])) {
            // $regex permet de filtrer sur le début de la date ex: "2026-01"
            $match['date_terminee'] = ['$regex' => $filtres['mois']];
        }
        if (!empty($match)) {
            $pipeline[] = ['$match' => $match];
        }
        
        // Étape 2 : $group — on regroupe par menu et on somme le CA
        $pipeline[] = ['$group' => [
            '_id' => '$menu_titre',
            'ca'  => ['$sum' => '$prix_total']  // somme des prix, pas compteur
        ]];
        
        // Étape 3 : $sort — du CA le plus élevé au plus bas
        $pipeline[] = ['$sort' => ['ca' => -1]];
        
        return $collection->aggregate($pipeline)->toArray();
    }
}