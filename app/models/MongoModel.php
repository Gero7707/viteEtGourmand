<?php
require_once __DIR__ . '/../../core/MongoDatabase.php';

class MongoModel{
    

public function insertCommande(array $data): void {
        $collection = MongoDatabase::getInstance()->getCollection('commandes');
        $collection->insertOne($data);
    }
}