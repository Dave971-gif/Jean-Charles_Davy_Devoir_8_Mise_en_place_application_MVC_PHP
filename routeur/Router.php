<?php
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$routes = new RouteCollection();

// Putting definitions of routes here
$routes->add('home', new Route('/', ['_controller' => ['app\controller\HomeController', 'index']]));

return $routes;

?>