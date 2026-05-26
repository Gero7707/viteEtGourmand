<?php
/**
 * Classe Database — Connexion PDO à la base de données
 * Implémente le pattern Singleton pour garantir une seule instance de connexion
 * pendant toute la durée de la requête HTTP
 *
 * Usage dans les Models :
 *   $this->pdo = Database::getInstance()->getConnection();
 *
 * Variables d'environnement requises dans .env et docker-compose.yml :
 *   DB_HOST, DB_PORT, DB_NAME, DB_USER, DB_PASSWORD
 */
class Database{

    /**
     * Instance unique de la classe — null jusqu'au premier appel de getInstance()
     * static permet de persister la valeur entre les appels
     */
    private static $instance = null;

    /**
     * Objet PDO — connexion active à la base de données
     */
    private $pdo;

    /**
     * Constructeur privé — empêche l'instanciation directe avec new Database()
     * Force l'utilisation de getInstance() pour respecter le pattern Singleton
     * Lit les credentials depuis les variables d'environnement via getenv()
     */
    private function __construct(){
        $host     = getenv('DB_HOST');
        $port     = getenv('DB_PORT');
        $dbname   = getenv('DB_NAME');
        $username = getenv('DB_USER');
        $password = getenv('DB_PASSWORD');

        try{
            // DSN — Data Source Name : chaîne de connexion MySQL
            $dsn = "mysql:host={$host};port={$port};dbname={$dbname}";
            $this->pdo = new PDO($dsn, $username, $password);

            // Active le mode exception — les erreurs SQL lèvent des PDOException
            // plutôt que de retourner false silencieusement
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        }catch(PDOException $e){
            // Arrête l'exécution et affiche l'erreur de connexion
            // En production, logger l'erreur plutôt que de l'afficher
            die("Database connection failure: " . $e->getMessage());
        }
    }

    /**
     * Point d'accès unique à l'instance — crée la connexion si elle n'existe pas encore
     * Retourne toujours la même instance (Singleton)
     *
     * @return Database
     */
    public static function getInstance(): Database {
        if(self::$instance === null){
            self::$instance = new Database();
        }
        return self::$instance;
    }

    /**
     * Retourne l'objet PDO pour exécuter des requêtes
     * Appelé dans le constructeur de chaque Model
     *
     * @return PDO
     */
    public function getConnection(): PDO {
        return $this->pdo;
    }
}