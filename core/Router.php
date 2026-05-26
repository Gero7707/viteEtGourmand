<?php

class Router{
    private $routes;

    public function add($url,$controller,$method){
        $this->routes[$url]=['controller' => $controller , 'method' => $method];
    }

    public function dispatch($url){
        if(isset($this->routes[$url])){
            $controllerName = $this->routes[$url]['controller'];
            $methodName = $this->routes[$url]['method'];

            if(class_exists($controllerName)){
                $controller = new $controllerName();

                if(method_exists($controller, $methodName)){
                    return $controller->$methodName();
                }else{
                    http_response_code(404);
                    echo "Methode  non trouvée !";
                }
            }else{
                http_response_code(404);           
                echo "Controller non trouvé !";
            }
        }else{
            http_response_code(404);
            echo "Route non trouvée: " . htmlspecialchars($url);
        }
    }
}