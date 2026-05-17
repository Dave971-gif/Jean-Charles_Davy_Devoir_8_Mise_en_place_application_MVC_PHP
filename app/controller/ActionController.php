<?php
namespace app\controller;

use PDO;

class ActionController {
    private PDO $db;

    // Le constructeur récupère la connexion BDD automatiquement
    public function __construct() {
        // Connection to the database using PDO, with error handling
        try {
            $this->db = new PDO('mysql:host=localhost;dbname=jeu_essai;charset=utf8', 'root', '');
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (\Exception $e) {
            die('Erreur de connexion à la base de données : ' . $e->getMessage());
        }
    }

    // ==========================================
    //          AGENCY ACTIONS (CRUD)
    // ==========================================

    public function createAgency() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = $_POST['nom'] ?? '';
            
            if (!empty($nom)) {
                $stmt = $this->db->prepare("INSERT INTO agencies (nom) VALUES (:nom)");
                $stmt->execute(['nom' => $nom]);
                
                $_SESSION['flash'] = "L'agence a été créée avec succès !";
                header('Location: ./');
                exit;
            }
        }

        // If GET : we display the creation form
        include __DIR__ . '/../../templates/agence.php';
        exit;
    }

    public function editAgency(int $id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = $_POST['nom'] ?? '';
            
            if (!empty($nom)) {
                $stmt = $this->db->prepare("UPDATE agencies SET nom = :nom WHERE id = :id");
                $stmt->execute(['nom' => $nom, 'id' => $id]);
                
                $_SESSION['flash'] = "L'agence a bien été modifiée !";
                header('Location: ./');
                exit;
            }
        }

        // If GET : we retrieve the existing agency to populate the fields in the view
        $stmt = $this->db->prepare("SELECT * FROM agencies WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $agence = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$agence) {
            $_SESSION['flash'] = "Agence introuvable.";
            header('Location: ./');
            exit;
        }

        include __DIR__ . '/../../templates/agence.php';
        exit;
    }

    public function deleteAgency(int $id) {
        // Suppression directe en BDD
        $stmt = $this->db->prepare("DELETE FROM agencies WHERE id = :id");
        $stmt->execute(['id' => $id]);
        
        $_SESSION['flash'] = "L'agence a été supprimée.";
        header('Location: ./');
        exit;
    }

    // ==========================================
    //          JOURNEY ACTIONS (CRUD)
    // ==========================================

    public function createJourney() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $depart = $_POST['depart'] ?? '';
            $depart_date = $_POST['depart_date'] ?? '';
            $destination = $_POST['destination'] ?? '';
            $destination_date = $_POST['destination_date'] ?? '';
            $places = $_POST['places'] ?? 0;
            $user_id = $_SESSION['user_id'] ?? null; // Assuming the user must be logged in to create a journey

            if (!empty($depart) && !empty($destination)) {
                $stmt = $this->db->prepare("INSERT INTO journey (depart, depart_date, destination, destination_date, places, user_id) VALUES (:depart, :depart_date, :destination, :destination_date, :places, :user_id)");
                $stmt->execute([
                    'depart' => $depart,
                    'depart_date' => $depart_date,
                    'destination' => $destination,
                    'destination_date' => $destination_date,
                    'places' => $places,
                    'user_id' => $user_id
                ]);

                $_SESSION['flash'] = "Votre trajet a été publié !";
                header('Location: ./');
                exit;
            }
        }

        // If GET : we display the creation form
        include __DIR__ . '/../../templates/journey.php';
        exit;
    }

    public function editJourney(int $id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $depart = $_POST['depart'] ?? '';
            $depart_date = $_POST['depart_date'] ?? '';
            $destination = $_POST['destination'] ?? '';
            $destination_date = $_POST['destination_date'] ?? '';
            $places = $_POST['places'] ?? 0;

            $stmt = $this->db->prepare("UPDATE journey SET depart = :depart, depart_date = :depart_date, destination = :destination, destination_date = :destination_date, places = :places WHERE id = :id");
            $stmt->execute([
                'depart' => $depart,
                'depart_date' => $depart_date,
                'destination' => $destination,
                'destination_date' => $destination_date,
                'places' => $places,
                'id' => $id
            ]);

            $_SESSION['flash'] = "Le trajet a été mis à jour avec succès.";
            header('Location: ./');
            exit;
        }

        // Si GET : on récupère le trajet existant pour alimenter les champs de la vue
        $stmt = $this->db->prepare("SELECT * FROM journey WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $trajet = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$trajet) {
            $_SESSION['flash'] = "Trajet introuvable.";
            header('Location: ./');
            exit;
        }

        include __DIR__ . '/../../templates/journey.php';
        exit;
    }

    public function deleteJourney(int $id) {
        // Suppression directe en BDD
        $stmt = $this->db->prepare("DELETE FROM journey WHERE id = :id");
        $stmt->execute(['id' => $id]);

        $_SESSION['flash'] = "Le trajet a été supprimé.";
        header('Location: ./');
        exit;
    }
}