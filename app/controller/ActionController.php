<?php
namespace app\controller;

use PDO;

class ActionController {
    private PDO $db;

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
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Cleaning the input
            $nom = trim($_POST['nom'] ?? '');

            if (!empty($nom)) {
                // Verifying if an agency with the same name already exists (case-insensitive)
                $checkStmt = $this->db->prepare("SELECT COUNT(*) FROM agencies WHERE LOWER(nom) = LOWER(:nom)");
                $checkStmt->execute(['nom' => $nom]);
                $agencyExists = $checkStmt->fetchColumn();

                if ($agencyExists > 0) {
                    // If agency with the same name already exists, we set an error message to display in the view
                    $error = "Impossible d'ajouter cette agence : la ville '$nom' existe déjà !";

                } else {
                    if (!empty($nom)) {
                        $stmt = $this->db->prepare("INSERT INTO agencies (nom) VALUES (:nom)");
                        $stmt->execute(['nom' => $nom]);

                        $_SESSION['flash'] = "L'agence a été créée avec succès !";
                        header('Location: /');
                        exit;
                    }
                }
            }
        }
        
        $stmt = $this->db->query("SELECT * FROM agencies");
        $agences = $stmt->fetchAll();

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
                header('Location: /');
                exit;
            }
        }

        // If GET : we retrieve the existing agency to populate the fields in the view
        $stmt = $this->db->prepare("SELECT * FROM agencies WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $agence = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$agence) {
            $_SESSION['flash'] = "Agence introuvable.";
            header('Location: /');
            exit;
        }

        include __DIR__ . '/../../templates/agence.php';
        exit;
    }

    public function deleteAgency(int $id) {
        $stmt = $this->db->prepare("DELETE FROM agencies WHERE id = :id");
        $stmt->execute(['id' => $id]);
        
        $_SESSION['flash'] = "L'agence a été supprimée.";
        header('Location: /');
        exit;
    }


    // ==========================================
    //          JOURNEY ACTIONS (CRUD)
    // ==========================================

    public function createJourney(): void {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $depart = $_POST['depart'] ?? '';
            $depart_date = $_POST['depart_date'] ?? ''; 
            $destination = $_POST['destination'] ?? '';
            $destination_date = $_POST['destination_date'] ?? ''; 
            $places = $_POST['places'] ?? 1;
            $user_id = $_SESSION['user_id'] ?? null;

            if ($depart === $destination) {
                die("Erreur : La ville de départ et la destination ne peuvent pas être identiques.");
            }

            if (strtotime($depart_date) < strtotime('today')) {
                die("Erreur : La date de départ ne peut pas être dans le passé.");
            }
            
            if (strtotime($destination_date) < strtotime($depart_date)) {
                die("Erreur : La date d'arrivée ne peut pas être antérieure à la date de départ.");
            }
            
            if (!empty($depart) && !empty($destination)) {
                $stmt = $this->db->prepare("INSERT INTO journey (depart, depart_date, destination, destination_date, places, user_id) 
                VALUES (:depart, :depart_date, :destination, :destination_date, :places, :user_id)");
                
                $stmt->execute([
                    'depart' => $depart,
                    'depart_date' => $depart_date,
                    'destination' => $destination,
                    'destination_date' => $destination_date,
                    'places' => $places,
                    'user_id' => $user_id
                ]);

                $_SESSION['flash'] = "Votre trajet a été publié !";
                header('Location: /');
                exit;
            }
        }

        $id = null;
        $trajet = null;
        
        $agencyStmt = $this->db->query("SELECT * FROM agencies ORDER BY nom ASC");
        $agences = $agencyStmt->fetchAll(PDO::FETCH_ASSOC);

        $user = null;

        if (isset($_SESSION['user_id'])) {
            $userStmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
            $userStmt->execute(['id' => $_SESSION['user_id']]);
            $user = $userStmt->fetch(PDO::FETCH_ASSOC);
        }

        include __DIR__ . '/../../templates/journey.php';
        exit;
    }

    public function editJourney(int $id): void {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $depart = $_POST['depart'] ?? '';
            $depart_date = $_POST['depart_date'] ?? '';
            $destination = $_POST['destination'] ?? '';
            $destination_date = $_POST['destination_date'] ?? '';
            $places = $_POST['places'] ?? 1;

            if ($depart === $destination) {
                die("Erreur : La ville de départ et la destination ne peuvent pas être identiques.");
            }

            if (strtotime($depart_date) < strtotime('today')) {
            die("Erreur : La date de départ ne peut pas être dans le passé.");
            }

            if (strtotime($destination_date) < strtotime($depart_date)) {
                die("Erreur : La date d'arrivée ne peut pas être antérieure à la date de départ.");
            }

            $stmt = $this->db->prepare("UPDATE journey SET depart = :depart, depart_date = :depart_date, destination = :destination, destination_date = :destination_date, places = :places 
            WHERE id = :id");
            $stmt->execute([
                'depart' => $depart,
                'depart_date' => $depart_date,
                'destination' => $destination,
                'destination_date' => $destination_date,
                'places' => $places,
                'id' => $id
            ]);

            $_SESSION['flash'] = "Le trajet a été mis à jour avec succès.";
            header('Location: /');
            exit;
        }

        // If GET request, we fetch the existing journey data to pre-fill the form
        $stmt = $this->db->prepare("SELECT * FROM journey WHERE id = :id ORDER BY depart_date ASC, depart ASC");
        $stmt->execute(['id' => $id]);
        $trajet = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$trajet) {
            $_SESSION['flash'] = "Trajet introuvable.";
            header('Location: /');
            exit;
        }

        // Security check: only the owner of the journey or an admin can edit it
        if ($trajet['user_id'] != $_SESSION['user_id'] && $_SESSION['role'] !== 'admin') {
            $_SESSION['flash'] = "Vous n'avez pas l'autorisation de modifier ce trajet.";
            header('Location: /');
            exit();
        }

        $agencyStmt = $this->db->query("SELECT * FROM agencies ORDER BY nom ASC");
        $agences = $agencyStmt->fetchAll(PDO::FETCH_ASSOC);

        $user = null;
        
        if (isset($_SESSION['user_id'])) {
            $userStmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
            $userStmt->execute(['id' => $_SESSION['user_id']]);
            $user = $userStmt->fetch(PDO::FETCH_ASSOC);
        }
    
        include __DIR__ . '/../../templates/journey.php';
        exit;
    }

    public function deleteJourney(int $id): void {
        $stmt = $this->db->prepare("DELETE FROM journey WHERE id = :id");
        $stmt->execute(['id' => $id]);

        $_SESSION['flash'] = "Le trajet a été supprimé.";
        header('Location: /');
        exit;
    }
}
?>