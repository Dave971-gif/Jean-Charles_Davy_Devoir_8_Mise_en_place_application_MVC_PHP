<?php
session_start();  

// Logout handling: If the URL contains ?action=logout, we log the user out
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    // Emptying the session array
    $_SESSION = [];

    // Destroying the session cookie if it exists
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    // Destroying the session
    session_destroy();
    
    // Redirecting to the home page after logout
    header("Location: ./");
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';

require_once __DIR__ . '/routeur/Router.php';

?>