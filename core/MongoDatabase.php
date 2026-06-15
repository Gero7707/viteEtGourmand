<?php

class MongoDatabase{

    private static ?MongoDatabase $MongoInstance = null;

    private object $mongo;

    private function __construct(){
        $host     = getenv('MONGO_HOST');
        $port     = getenv('MONGO_PORT');
        $dbname   = getenv('MONGO_DB');
        // $username = getenv('');
        // $password = getenv('');

        try{
            $dsn = "mongodb://{$host}:{$port}";
            $this->mongo = new MongoDB\Client($dsn);
        }catch(Exception $e){
            die("Database connection failure: " . $e->getMessage());
        }
    }

    public static function getInstance(): MongoDatabase {
        if(self::$MongoInstance === null){
            self::$MongoInstance = new MongoDatabase();
        }
        return self::$MongoInstance;
    }

    public function getCollection(string $collectionName): object {
        $dbname = getenv('MONGO_DB');
        return $this->mongo->$dbname->$collectionName; 
    }
}