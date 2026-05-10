<?php

namespace app\controller;

use core\Database;

class HomeController {

    public function index() {
        // Initialising the visitor's role, defaulting to 'visitor' if not set
        $role = $_SESSION['role'] ?? 'visitor';
        $db = Database::getConnection(); // Connection to database
        
        // Initialising variables to pass to the view
        $trajets = [];
        $users = [];
        $agences = [];

        // Fetching data based on the user's role
        if ($role === 'admin') { 
            $trajets = $db->query("SELECT * FROM journey")->fetchAll();
            $users = $db->query("SELECT * FROM users")->fetchAll();
            $agences = $db->query("SELECT * FROM agencies")->fetchAll();
        } 
        elseif ($role === 'user') {
            $trajets = $db->query("SELECT * FROM journey WHERE places > 0")->fetchAll();
        } 
        else {
            $trajets = $db->query("SELECT * FROM journey WHERE places > 0 AND depart_date >= CURDATE()")->fetchAll();
        }

        // On inclut la vue qui va dispatcher l'affichage
        include __DIR__ . '/../../templates/home.php';
    }
}
?>