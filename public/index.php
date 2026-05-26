<?php
require_once  __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../core/Router.php';

$router = new Router();
$url = strtok($_SERVER['REQUEST_URI'], '?');

$router->dispatch($url);

?>