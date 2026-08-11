<?php

/**
 * Point d'accès unique à la base MongoDB (analytics/commandes terminées).
 * Implémente le pattern Singleton : une seule connexion MongoDB
 * existe pour toute la durée de la requête PHP.
 * Jumeau de Database.php (PDO/MySQL), mais côté MongoDB.
 */
class MongoDatabase{

    // L'unique instance de la classe, partagée par tout le code.
    // Typé ?MongoDatabase (nullable) car vaut null tant que personne
    // n'a appelé getInstance(). static = attaché à la classe, pas à un objet.
    private static ?MongoDatabase $MongoInstance = null;

    // Le client MongoDB (la connexion réelle).
    // Typé object plutôt que MongoDB\Client pour éviter les faux positifs
    // d'Intelephense, qui n'analyse pas toujours l'extension mongodb.
    private object $mongo;

    // Constructeur privé : cœur du Singleton.
    // "private" empêche de faire "new MongoDatabase()" depuis l'extérieur,
    // ce qui force à passer par getInstance() → une seule connexion possible.
    private function __construct(){

        try{
            // Deux façons de se connecter selon l'environnement :
            // - MONGO_DSN : chaîne complète fournie telle quelle (ex. Atlas en prod).
            // - Sinon : on reconstruit une URI locale depuis l'hôte et le port (Docker).
            // ?: (opérateur Elvis) = utilise MONGO_DSN s'il existe et n'est pas vide,
            //     sinon retombe sur la construction manuelle.
            $dsn = getenv('MONGO_DSN') ?: 'mongodb://' . getenv('MONGO_HOST') . ':' . getenv('MONGO_PORT');

            // Ouverture de la connexion. À la différence de PDO,
            // pas de setAttribute() : le driver MongoDB lève des exceptions par défaut.
            $this->mongo = new MongoDB\Client($dsn);
        }catch(Exception $e){
            // Échec de connexion : on arrête net l'exécution avec un message.
            // (Simple mais suffisant ici ; en prod on préférerait logguer sans exposer le détail.)
            die("Database connection failure: " . $e->getMessage());
        }
    }

    /**
     * Retourne l'unique instance de MongoDatabase (la crée au premier appel).
     * C'est le SEUL point d'entrée pour obtenir l'objet : garantit une connexion unique.
     */
    public static function getInstance(): MongoDatabase {
        // Instanciation "paresseuse" : on ne crée l'objet que la première fois.
        if(self::$MongoInstance === null){
            self::$MongoInstance = new MongoDatabase();
        }
        return self::$MongoInstance;
    }

    /**
     * Renvoie une collection MongoDB prête à l'emploi (insertOne, find, etc.).
     * @param string $collectionName Nom de la collection (ex. 'commandes').
     */
    public function getCollection(string $collectionName): object {
        // Nom de la base lu dans l'environnement au moment de l'appel
        // (pas stocké en propriété : récupéré à la demande).
        $dbname = getenv('MONGO_DB');

        // Accès dynamique : $this->mongo->{base}->{collection}.
        // MongoDB\Client surcharge l'accès propriété pour exposer bases et collections.
        return $this->mongo->$dbname->$collectionName; 
    }
}