<?php
namespace core;

use PDO;
use PDOException;

class Database {
    private static ?PDO $instance = null; 
    public static function getConnection() {
        if (self::$instance === null) {
            $host = 'localhost';
            $db   = 'jeu_essai';
            $user = 'root';           
            $pass = '';               

            try {
                self::$instance = new PDO(
                    "mysql:host=$host;dbname=$db;charset=utf8mb4",
                    $user,
                    $pass,
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                    ]
                );
            } catch (PDOException $e) {
                die("Erreur de connexion : " . $e->getMessage());
            }
        }
        return self::$instance;
    }
}
?>