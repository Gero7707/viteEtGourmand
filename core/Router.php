<?php
/**
 * Classe Router — Routeur maison du framework
 * Associe des URLs à des méthodes de controllers et dispatche les requêtes
 *
 * Fonctionnalités :
 * - Distinction GET / POST par route
 * - Routes dynamiques avec paramètres (ex: /menu/{id})
 * - Paramètres capturés et passés automatiquement à la méthode du controller
 *
 * Usage dans index.php :
 *   $router->add('GET', '/menus', 'MenuController', 'index');
 *   $router->add('GET', '/menu/{id}', 'MenuController', 'show');
 *   $router->add('POST', '/connexion', 'AuthController', 'login');
 *   $router->dispatch($url);
 */
class Router{

    /**
     * Tableau des routes enregistrées
     * Chaque route : ['httpMethod' => 'GET', 'url' => '/menu/{id}', 'controller' => 'MenuController', 'action' => 'show']
     */
    private array $routes;

    /**
     * Enregistre une nouvelle route
     *
     * @param string $httpMethod Méthode HTTP (GET ou POST)
     * @param string $url        Chemin URL (ex: '/menu/{id}')
     * @param string $controller Nom de la classe controller (ex: 'MenuController')
     * @param string $action     Nom de la méthode à appeler (ex: 'show')
     */
    public function add(string $httpMethod, string $url, string $controller, string $action): void {
        $this->routes[] = [
            'httpMethod' => strtoupper($httpMethod),
            'url'        => $url,
            'controller' => $controller,
            'action'     => $action
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
        // Nettoie l'URL : retire le slash final sauf pour "/"
        // /menus/ et /menus pointent vers la même route
        $url = rtrim($url, '/') ?: '/';

        // Récupère la méthode HTTP de la requête (GET, POST...)
        $httpMethod = $_SERVER['REQUEST_METHOD'];

        // Parcourt toutes les routes enregistrées
        foreach ($this->routes as $route) {

            // Vérifie d'abord la méthode HTTP — si c'est POST et la route attend GET, on passe
            if ($route['httpMethod'] !== $httpMethod) {
                continue;
            }

            // Transforme le pattern de route en regex
            // /menu/{id} devient /menu/([^/]+)
            // {id} est remplacé par ([^/]+) qui capture tout sauf un slash
            $pattern = preg_replace('#\{([a-zA-Z_]+)\}#', '([^/]+)', $route['url']);
            $pattern = '#^' . $pattern . '$#';

            // Teste si l'URL correspond au pattern
            if (preg_match($pattern, $url, $matches)) {

                // $matches[0] contient l'URL complète, on la retire
                // $matches[1], [2]... contiennent les paramètres capturés ({id}, etc.)
                array_shift($matches);

                $controllerName = $route['controller'];
                $actionName = $route['action'];

                if (!class_exists($controllerName)) {
                    http_response_code(404);
                    echo "Contrôleur non trouvé : " . htmlspecialchars($controllerName);
                    return;
                }

                $controller = new $controllerName();

                if (!method_exists($controller, $actionName)) {
                    http_response_code(404);
                    echo "Méthode non trouvée : " . htmlspecialchars($actionName);
                    return;
                }

                // Appelle la méthode du controller en passant les paramètres capturés
                // Ex : /menu/3 → $controller->show("3")
                call_user_func_array([$controller, $actionName], $matches);
                return;
            }
        }

        // Aucune route ne correspond
        http_response_code(404);
        echo "Page non trouvée : " . htmlspecialchars($url);
    }
}