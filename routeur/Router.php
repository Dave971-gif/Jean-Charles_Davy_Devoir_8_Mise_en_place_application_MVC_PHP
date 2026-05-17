<?php

use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\HttpFoundation\Request;

use app\controller\HomeController;
use app\controller\ActionController;


// 1. Routes Configs
$routes = new RouteCollection();

// Display routes
$routes->add('home', new Route('/', ['_controller' => [HomeController::class, 'index']]));
$routes->add('login', new Route('/login', ['_controller' => [HomeController::class, 'index']]));
$routes->add('check_password', new Route('/check_password', ['_controller' => [HomeController::class, 'index']]));
$routes->add('password', new Route('/password', ['_controller' => [HomeController::class, 'index']]));

// Action routes for agencies and journeys (create, edit, delete)
$routes->add('create_agency', new Route('/agency/create', ['_controller' => [ActionController::class, 'createAgency']]));
$routes->add('edit_agency', new Route('/agency/{id}/edit', ['_controller' => [ActionController::class, 'editAgency']]));
$routes->add('delete_agency', new Route('/agency/{id}/delete', ['_controller' => [ActionController::class, 'deleteAgency']]));
$routes->add('create_journey', new Route('/journey/create', ['_controller' => [ActionController::class, 'createJourney']]));
$routes->add('edit_journey', new Route('/journey/{id}/edit', ['_controller' => [ActionController::class, 'editJourney']]));
$routes->add('delete_journey', new Route('/journey/{id}/delete', ['_controller' => [ActionController::class, 'deleteJourney']]));

// 2. Analyze the current URL and match it to a route
$context = new RequestContext();
$context->fromRequest(Request::createFromGlobals());
$matcher = new UrlMatcher($routes, $context);

try {
    $parameters = $matcher->match($context->getPathInfo());
    list($controllerClass, $method) = $parameters['_controller'];
    
    // Cleaning up the parameters to only keep those that are needed for the controller method (like $id for edit/delete)
    unset($parameters['_route'], $parameters['_controller']);
    
    $controller = new $controllerClass();
    
    // Calling the controller method with the parameters extracted from the URL
    call_user_func_array([$controller, $method], $parameters);

} catch (ResourceNotFoundException $e) {
    header("HTTP/1.0 404 Not Found");
    echo "Page introuvable.";
}

?>