<?php
require_once __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\HttpFoundation\Request;

// 1. Routes Configs
$routes = new RouteCollection();

// URL Source "/" must display the home.php content
$routes->add('home', new Route('/', ['_controller' => 'home.php']));

// 2. Analyze the current URL and match it to a route
$context = new RequestContext();
$context->fromRequest(Request::createFromGlobals());
$matcher = new UrlMatcher($routes, $context);

try {
    // Searching for a route that matches the current URL ('/')
    $parameters = $matcher->match($context->getPathInfo());
    
    // Instead of redirecting to "home.php", we include its content directly.
    // The URL in the browser will remain "localhost/", but the user will see the homepage.
    include __DIR__ . '/templates/' . $parameters['_controller'];

} catch (ResourceNotFoundException $e) {
    // If the user types a URL that does not exist
    header("HTTP/1.0 404 Not Found");
    echo "Page introuvable.";
}

?>