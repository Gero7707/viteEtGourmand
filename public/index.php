<?php
require_once __DIR__ . '/../vendor/autoload.php';

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();
/**
 * Point d'entrée unique de l'application — pattern Front Controller
 * Toutes les requêtes HTTP passent par ce fichier (configuré dans apache.conf)
 */

// ============================================================
// CONFIGURATION DE LA SESSION
// Doit être appelé avant tout output et avant d'utiliser $_SESSION
// ============================================================
session_start([
    'cookie_httponly' => true,    // JavaScript ne peut pas lire le cookie de session — protection XSS
    'cookie_secure' => false,     // Cookie envoyé uniquement en HTTPS — passer à true en production
    'cookie_samesite' => 'Strict', // Cookie non envoyé depuis un site externe — protection CSRF
    'use_strict_mode' => true,    // Refuse les id de session non générés par le serveur — protection session fixation
    'use_only_cookies' => true,   // Interdit les id de session dans l'URL — protection session hijacking
    'gc_maxlifetime' => 1800      // Session expire après 30 min d'inactivité
]);

// ============================================================
// CHARGEMENT DES CLASSES CORE
// Ordre important : Database et Router avant les controllers
// ============================================================
require_once __DIR__ . '/../core/Database.php';  // Singleton PDO — connexion BDD
require_once __DIR__ . '/../core/MongoDatabase.php';  // Singleton MongoDB
require_once __DIR__ . '/../core/Router.php';     // Router maison — dispatch par URL
require_once __DIR__ . '/../core/Auth.php';       // Méthodes statiques de sécurité — CSRF, checkAuth, checkAdmin

// ============================================================
// CHARGEMENT DES CONTROLLERS
// Ajouter un require_once ici pour chaque nouveau controller
// ============================================================
require_once __DIR__ . '/../app/controllers/AuthController.php';
require_once __DIR__ . '/../app/controllers/HomeController.php';
require_once __DIR__ . '/../app/controllers/AdminController.php';
require_once __DIR__ . '/../app/controllers/PasswordResetController.php';
require_once __DIR__ . '/../app/controllers/MenuController.php';
require_once __DIR__ . '/../app/controllers/AvisController.php';
require_once __DIR__ . '/../app/controllers/ProfileController.php';
require_once __DIR__ . '/../app/controllers/CommandeController.php';
require_once __DIR__ . '/../app/controllers/EmployeController.php';
require_once __DIR__ . '/../app/controllers/ContactController.php';
require_once __DIR__ . '/../app/controllers/HoraireController.php';
require_once __DIR__ . '/../app/controllers/PlatController.php';

// ============================================================
// ROUTING
// Instanciation du router et extraction de l'URL sans les paramètres GET
// ============================================================
$router = new Router();

// strtok() supprime la query string (?param=value) pour ne garder que le chemin
$url = strtok($_SERVER['REQUEST_URI'], '?');

// ============================================================
// DÉCLARATION DES ROUTES
// Format : add(httpMethod, url, NomController, nomAction)
// Routes protégées : Auth::checkAuth() ou Auth::checkAdmin() appelé dans le controller
// Routes publiques : pas de protection nécessaire
// ============================================================

// Page d'accueil — publique
$router->add('GET', '/', 'HomeController', 'showLanding');

// Routes admin — protégées par Auth::checkAdmin()
$router->add('GET', '/admin/dashboard', 'AdminController', 'dashboard');

// Routes admin — protégées par Auth::checkEmploye()
$router->add('GET' , '/employe/dashboard' , 'EmployeController' , 'dashboard' );

// Authentification — login
$router->add('GET', '/auth/login', 'AuthController', 'loginForm');
$router->add('POST', '/auth/login', 'AuthController', 'login');

// Authentification — inscription
$router->add('GET', '/auth/register', 'AuthController', 'registerForm');
$router->add('POST', '/auth/register', 'AuthController', 'register');

//Création de compte pour employé par admin
$router->add('GET' , '/admin/employe-register' , 'AdminController' , 'ShowRegisterEmploye');
$router->add('POST' , '/admin/employe-register' , 'AdminController' , 'registerEmploye');
//Désactiver un compte employé
$router->add('POST' , '/admin/desactiver/{id}' , 'AdminController' , 'desactiverEmploye');
//Activer un employé
$router->add('POST' , '/admin/activer/{id}' , 'AdminController' , 'activerEmploye');
//Modifier profil employé 
$router->add('GET' , '/admin/update-employe/{id}' , 'AdminController' , 'showModifEmploye');
$router->add('POST' , '/admin/update-employe/{id}' , 'AdminController' , 'updateEmploye');

// Authentification — déconnexion
$router->add('GET', '/auth/logout', 'AuthController', 'logOut');

// Mot de passe oublié
$router->add('GET', '/auth/forgot-password', 'PasswordResetController', 'forgotPasswordForm');
$router->add('POST', '/auth/forgot-password', 'PasswordResetController', 'forgotPassword');

// Réinitialisation du mot de passe
$router->add('GET', '/auth/reset-password', 'PasswordResetController', 'resetPasswordForm');
$router->add('POST', '/auth/reset-password', 'PasswordResetController', 'resetPassword');

//Afficher la vue globale des menus et filtres
$router->add('GET' , '/menus' , 'MenuController' , 'index');
//Créer un menu
$router->add('GET' , '/create-menu' , 'MenuController' , 'showFormMenu');
$router->add('POST' , '/create-menu' , 'MenuController' , 'createMenu');
//Modifier un menu
$router->add('GET' , '/menus/edit/{id}' , 'MenuController' , 'showEditMenu');
$router->add('POST' , '/menus/edit/{id}' , 'MenuController' , 'updateMenu');
$router->add('POST' , '/menus/delete/{id}' , 'MenuController' , 'deleteMenu');

//Afficher un menu
$router->add('GET' , '/menus/{id}' , 'MenuController' , 'show');

//Afficher la vue des avis validés
$router->add('GET' , '/avis' , 'AvisController' , 'index');
//Afficher avis en attente 
$router->add('GET' , '/avis-valider' , 'AvisController' , 'avisToValidate');
$router->add('POST' , '/avis-valider/{id}' , 'AvisController' , 'changeStatut');
//Noter une commande
$router->add('GET' , '/avis/noter/{id}' , 'AvisController' , 'showAvisForm');
$router->add('POST' , '/avis/noter-commande/{id}' , 'AvisController' , 'noterCommande');
//Modifier un avis
$router->add('GET' , '/avis/edit/{id}' , 'AvisController' , 'showEditForm');
$router->add('POST' , '/avis/edit/{id}' , 'AvisController' , 'updateAvis');


//Afficher profil utilisateur
$router->add('GET' , '/profile' , 'ProfileController' , 'showProfile');

//Afficher une commande 
$router->add('GET' , '/commandes/{id}' , 'CommandeController' , 'show');

//Afficher commandes client vue employé
$router->add('GET' , '/commandes-client' , 'CommandeController' , 'showAllCommandes');
$router->add('POST' , '/commandes/update/{id}' , 'CommandeController' , 'changerStatutCommande');
$router->add('GET' , '/commandes/annuler-commande/{id}' , 'CommandeController' , 'showFormAnnuler');
$router->add('POST' , '/commandes/annuler-commande/{id}' , 'CommandeController' , 'annulerCommandeEmploye');

//Afficher  les plats
$router->add('GET' , '/plats' , 'PlatController' , 'showAllPlats');
$router->add('GET' , '/plats/create' , 'PlatController' , 'showCreatePlat');
$router->add('POST' , '/plats/create' , 'PlatController' , 'createPlat');
$router->add('GET' , '/plats/edit/{id}' , 'PlatController' , 'showEditPlat');
$router->add('POST' , '/plats/edit/{id}' , 'PlatController' , 'updatePlat');
$router->add('POST' , '/plats/delete/{id}' , 'PlatController' , 'deletePlat');
$router->add('POST' , '/plats/associer/{id}' , 'PlatController' , 'associerPlat');
$router->add('POST' , '/plats/dissocier/{id}' , 'PlatController' , 'dissocierPlat');

//Afficher page contact
$router->add('GET' , '/contact' , 'ContactController' , 'showForm');
$router->add('POST' , '/contact' , 'ContactController' , 'sendMessage');

//Afficher modifier profile
$router->add('GET' , '/profile/edit' , 'ProfileController' , 'editProfile');
$router->add('POST' , '/profile/edit' , 'ProfileController' , 'edit');

//Formulaire commandes
$router->add('POST', '/commandes/calcul-frais', 'CommandeController', 'calculFrais');
$router->add('POST', '/commandes/create', 'CommandeController', 'create');
$router->add('GET', '/commandes/create/{menu_id}', 'CommandeController', 'showForm');
$router->add('POST' , '/commandes/annuler/{id}' , 'CommandeController' , 'annulerCommande');

//Formulaire modification de commande
$router->add('GET' , '/commandes/edit/{id}' , 'CommandeController' , 'showUpdate');
$router->add('POST' , '/commandes/edit/{id}' , 'CommandeController' , 'updateCommande');

//Changer horaire
$router->add('GET' , '/changer-horaire' , 'HoraireController' , 'showFormHoraire');
$router->add('POST' , '/changer-horaire' , 'HoraireController' , 'updateHoraire');
//Ajouter un jour
$router->add('POST' , '/ajout-jour' , 'HoraireController' , 'ajouterJour');
//Supprimer jour
$router->add('POST' , '/supp-jour/{id}' , 'HoraireController' , 'supprimerJour');


//Afficher les allergènes dans une modal
$router->add('GET' , '/fetch/menu-allergene/{id}' , 'MenuController' , 'getAllAllergene');

//Afficher filtres ca adminDashboard
$router->add('GET' , '/admin/stats-ca' , 'AdminController' , 'statsCA');


// Dispatch — cherche la route correspondante et appelle le bon controller/méthode
$router->dispatch($url);