<?php
// Autoloader and db charging
require_once __DIR__ . '/../vendor/autoload.php';
use core\Database;

// Security verification: Only logged-in users can access this page
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$db = Database::getConnection();
$id = $_GET['id'] ?? null; // Retrieving the journey ID from the URL (if any)
$trajet = null;

// If ID, we are in edit mode, we fetch the journey data to pre-fill the form. Otherwise, we are in create mode and the form will be empty.
if ($id) {
    $stmt = $db->prepare("SELECT * FROM journey WHERE id = ?");
    $stmt->execute([$id]);
    $trajet = $stmt->fetch();
    
    // Security: Only the author can modify their journey (unless admin)
    if ($trajet['user_id'] != $_SESSION['user_id'] && $_SESSION['role'] !== 'admin') {
        $_SESSION['flash'] = "Vous n'avez pas l'autorisation de modifier ce trajet.";
        header('Location: ../index.php');
        exit();
    }
}

// Treat form submission for both creation and modification
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $depart = $_POST['depart'];
    $depart_date = $_POST['date'];
    $destination = $_POST['destination'];
    $destination_date = $_POST['date'];
    $places = $_POST['places'];
    $user_id = $_SESSION['user_id'];

    if ($id) {
        // Update mode
        $stmt = $db->prepare("UPDATE journey SET depart = ?, depart_date = ?, destination = ?, destination_date = ?, places = ?, user_id = ? WHERE id = ?");
        $stmt->execute([$id, $depart, $depart_date, $destination, $destination_date, $places, $_SESSION['user_id']]);
        $_SESSION['flash'] = "Le trajet a été mis à jour avec succès !";
    } else {
        // Insert mode
        $stmt = $db->prepare("INSERT INTO journey (depart, depart_date, destination, destination_date, places, user_id) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$depart, $depart_date, $destination, $destination_date, $places, $_SESSION['user_id']]);
        $_SESSION['flash'] = "Votre trajet a été publié !";
    }

    header('Location: ../index.php');
    exit();
}
?>

<?php include 'header.php'; ?>

<main class="container mt-5">
    <h1><?= $id ? 'Modifier le trajet' : 'Proposer un trajet' ?></h1>
    
    <form method="POST" class="col-md-6 shadow p-4 rounded bg-light">
        <div class="mb-3">
            <label class="form-label">Ville de départ</label>
            <input type="text" name="depart" class="form-control" value="<?= $trajet['depart'] ?? '' ?>" required>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Destination</label>
            <input type="text" name="destination" class="form-control" value="<?= $trajet['destination'] ?? '' ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Date du trajet</label>
            <input type="datetime-local" name="date" class="form-control" value="<?= isset($trajet['depart_date']) ? date('Y-m-d\TH:i', strtotime($trajet['depart_date'])) : '' ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Places disponibles</label>
            <input type="number" name="places" class="form-control" value="<?= $trajet['places'] ?? '1' ?>" min="1" required>
        </div>

        <button type="submit" class="btn btn-primary">
            <?= $id ? 'Enregistrer les modifications' : 'Publier le trajet' ?>
        </button>
        <a href="../index.php" class="btn btn-link">Annuler</a>
    </form>
</main>