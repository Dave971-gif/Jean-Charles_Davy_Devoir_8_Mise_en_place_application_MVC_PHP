<?php

namespace app\controller;

class HomeController {
    public function index() {
        $db = \core\Database::getConnection(); // 1. Connexion to the database

        // 2. Queries to retrieve agencies data
        $query = $db->query("SELECT * FROM agencies");
        $agences = $query->fetchAll();

        // 3. Include the view to display the data
        include __DIR__ . '/../../templates/home.php';
    }
}
?>