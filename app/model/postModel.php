<?php
require_once 'db.php';
function getAllUsers() {
    global $bdd;
    
    $query = $bdd->query("SELECT * FROM posts");
    return $query->fetchAll(PDO::FETCH_ASSOC);
}