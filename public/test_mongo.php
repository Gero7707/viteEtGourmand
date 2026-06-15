<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../core/MongoDatabase.php';

try {
    $collection = MongoDatabase::getInstance()->getCollection('commandes');
    $collection->insertOne([
        'test' => true,
        'message' => 'connexion MongoDB OK'
    ]);
    echo "Insertion réussie !";
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
}