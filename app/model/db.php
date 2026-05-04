<?php

$host = 'localhost';
$dbname = 'jeu_essai';
$user = 'prof_test'; 
$password = 'DevProfCEF26';

try {
    // On crée la connexion
    $bdd = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    
    // On active les erreurs pour voir si une requête SQL plante
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    

} catch (Exception $e) {
    // En cas d'erreur, on affiche un message et on arrête le script
    die('Erreur de connexion à la base : ' . $e->getMessage());
}
?>