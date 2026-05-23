<?php

namespace app\controller;

use core\Database;

/**
 * Class HomeController
 *
 * Handles the main landing page and public home views.
 *
 * @package app\controller
 */

class HomeController {
    /**
     * Display the home page with different data based on the user's role (admin, user, visitor).
     * or redirects to the authentication/password pages.
     *
     * @return void
     */
    public function index(): void {
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
                       LEFT JOIN users u ON j.user_id = u.id
                       ORDER BY j.depart_date ASC, j.depart ASC";

        // Fetching data based on the user's role
        if ($role === 'admin') {
            $admin_trajets = $db->query($sqlTrajets)->fetchAll();
            $users = $db->query("SELECT * FROM users")->fetchAll();
            $agences = $db->query("SELECT * FROM agencies ORDER BY nom ASC")->fetchAll();
        } 
        elseif ($role === 'user') {
            // User sees all journeys with available places, including their own (even if full)

            $sqlUser = "SELECT j.*, u.prenom, u.nom, u.email, u.contact 
                        FROM journey j 
                        LEFT JOIN users u ON j.user_id = u.id 
                        WHERE j.places > 0 
                        ORDER BY j.depart_date ASC, j.depart ASC";
            $user_trajets = $db->query($sqlUser)->fetchAll();
        } 
        else {
            // Visitor sees exactly the same as the logged-in user
            $sqlGuest = "SELECT j.*, u.prenom, u.nom, u.email, u.contact 
                         FROM journey j 
                         LEFT JOIN users u ON j.user_id = u.id 
                         WHERE j.places > 0 
                         ORDER BY j.depart_date ASC, j.depart ASC";
            $guest_trajets = $db->query($sqlGuest)->fetchAll();
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

        } elseif (strpos($uri, '/password') !== false) {
            // If the URL contains "/password", we display the password creation page
            include __DIR__ . '/../../templates/password.php';
            exit();
            
        } else {
            // Otherwise, we display the home page with the appropriate data based on the user's role
            include __DIR__ . '/../../templates/home.php';
        }
    }
}
?>