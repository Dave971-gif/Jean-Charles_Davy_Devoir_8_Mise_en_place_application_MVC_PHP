<?php

namespace app\controller;

use core\Database;

class HomeController {

    public function index() {
        // Initialising the visitor's role, defaulting to 'visitor' if not set
        $role = $_SESSION['role'] ?? 'visitor';
        $db = Database::getConnection(); // Connection to database
        
        // Initialising variables to pass to the view
        $admin_trajets = [];
        $user_trajets = [];
        $guest_trajets = [];
        $users = [];
        $agences = [];

        $sqlTrajets = "SELECT j.*, u.prenom, u.nom, u.email, u.contact 
                       FROM journey j 
                       LEFT JOIN users u ON j.user_id = u.id";

        // Fetching data based on the user's role
        if ($role === 'admin') {
            $admin_trajets = $db->query($sqlTrajets)->fetchAll();
            $users = $db->query("SELECT * FROM users")->fetchAll();
            $agences = $db->query("SELECT * FROM agencies")->fetchAll();
        } 
        elseif ($role === 'user') {
            // User sees all journeys with available places, including their own (even if full)
            $user_trajets = $db->query($sqlTrajets . " WHERE j.places > 0")->fetchAll();
        } 
        else {
            // Visitor sees exactly the same as the logged-in user
            $guest_trajets = $db->query($sqlTrajets . " WHERE j.places > 0")->fetchAll();
        }

        $uri = $_SERVER['REQUEST_URI'];

        if (strpos($uri, '/login') !== false) {
            // If the URL contains "/login", we display the login form instead of the home page
            include __DIR__ . '/../../templates/login.php';
            exit();
        } elseif (strpos($uri, '/check_password') !== false) {
            // If the URL contains "/check_password", we display the password verification page
            include __DIR__ . '/../../templates/check_password.php';
            exit();
        // --- AJOUTE CE BLOC ICI ---
        } elseif (strpos($uri, '/password') !== false) {
            include __DIR__ . '/../../templates/password.php';
            exit;
        } else {
            // Otherwise, we display the home page with the appropriate data based on the user's role
            include __DIR__ . '/../../templates/home.php';
        }
    }
}
?>