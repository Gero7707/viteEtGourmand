<?php
/**
 * Classe Router — Routeur maison du framework
 * Associe des URLs à des méthodes de controllers et dispatche les requêtes
 *
 * Limitations actuelles :
 * - Ne distingue pas GET et POST (géré dans les controllers avec $_SERVER['REQUEST_METHOD'])
 * - Ne supporte pas les paramètres dynamiques dans l'URL (ex: /users/{id})
 * - Routing par URL exacte uniquement
 *
 * Usage dans index.php :
 *   $router->add('/ma-route', 'MonController', 'maMethode');
 *   $router->dispatch($url);
 */
class Router{

    /**
     * Tableau associatif des routes enregistrées
     * Format : ['url' => ['controller' => 'NomController', 'method' => 'nomMethode']]
     */
    private array $routes;

    /**
     * Enregistre une nouvelle route
     *
     * @param string $url        Chemin URL exact (ex: '/auth/login')
     * @param string $controller Nom de la classe controller (ex: 'AuthController')
     * @param string $method     Nom de la méthode à appeler (ex: 'login')
     */
    public function add(string $url, string $controller, string $method): void {
        $this->routes[$url] = [
            'controller' => $controller,
            'method' => $method
        ];
    }

    /**
     * Dispatche la requête vers le bon controller/méthode selon l'URL
     * Appelé une seule fois en bas de index.php avec l'URL courante
     * Retourne une erreur 404 si la route, le controller ou la méthode est introuvable
     *
     * @param string $url URL de la requête courante (sans query string)
     */
    public function dispatch(string $url): void {
        if(isset($this->routes[$url])){
            $controllerName = $this->routes[$url]['controller'];
            $methodName = $this->routes[$url]['method'];

            // Vérifie que la classe controller existe (require_once dans index.php)
            if(class_exists($controllerName)){
                $controller = new $controllerName();

                // Vérifie que la méthode existe dans le controller
                if(method_exists($controller, $methodName)){
                    $controller->$methodName();
                }else{
                    http_response_code(404);
                    echo "Méthode non trouvée : " . htmlspecialchars($methodName);
                }
            }else{
                http_response_code(404);
                echo "Controller non trouvé : " . htmlspecialchars($controllerName);
            }
        }else{
            // Aucune route ne correspond à l'URL demandée
            http_response_code(404);
            echo "Route non trouvée : " . htmlspecialchars($url);
        }
    }
}