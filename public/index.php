<?php
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

// ============================================================
// ROUTING
// Instanciation du router et extraction de l'URL sans les paramètres GET
// ============================================================
$router = new Router();

// strtok() supprime la query string (?param=value) pour ne garder que le chemin
$url = strtok($_SERVER['REQUEST_URI'], '?');

// ============================================================
// DÉCLARATION DES ROUTES
// Format : add(url, NomController, nomMethode)
// Routes protégées : Auth::checkAuth() ou Auth::checkAdmin() appelé dans le controller
// Routes publiques : pas de protection nécessaire
// ============================================================

// Routes admin — protégées par Auth::checkAdmin()
$router->add('/admin/showDashboard', 'AdminController', 'showDashboard');

// Routes publiques
$router->add('/', 'HomeController', 'showLanding');

// Routes d'authentification — publiques (login, register, logout, reset)
$router->add('/auth/login', 'AuthController', 'login');
$router->add('/auth/register', 'AuthController', 'register');
$router->add('/auth/logout', 'AuthController', 'logOut');
$router->add('/auth/forgotPassword', 'PasswordResetController', 'forgotPassword');
$router->add('/auth/resetPassword', 'PasswordResetController', 'resetPassword');

// Dispatch — cherche la route correspondante et appelle le bon controller/méthode
$router->dispatch($url);