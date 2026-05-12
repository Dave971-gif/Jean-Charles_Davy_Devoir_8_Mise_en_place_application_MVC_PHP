<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\HttpFoundation\Request;
use app\controller\HomeController;

// 1. Routes Configs
$routes = new RouteCollection();

// URL Source "/" must display the home.php content
$routes->add('home', new Route('/', ['_controller' => [HomeController::class, 'index']]));

// 2. Analyze the current URL and match it to a route
$context = new RequestContext();
$context->fromRequest(Request::createFromGlobals());
$matcher = new UrlMatcher($routes, $context);

try {
    $parameters = $matcher->match($context->getPathInfo());
    
    // Getting the controller and method to call from the route parameters
    list($controllerClass, $method) = $parameters['_controller'];
    
    $controller = new $controllerClass();
    
    // Calling the method
    $controller->$method();

} catch (ResourceNotFoundException $e) {
    // If the user types a URL that does not exist
    header("HTTP/1.0 404 Not Found");
    echo "Page introuvable.";
}

?>