<?php include 'header.php'; ?>

<?php
if (!isset($now)) {
    $now = date('Y-m-d');
}
?>

<main class="container mt-5">
    <h1><?= (isset($id) && $id) ? 'Modifier le trajet' : 'Proposer un trajet' ?></h1>
    
    <form method="POST" class="col-md-6 shadow p-4 rounded bg-light">
        <div class="mb-3">
            <label class="form-label">Ville de départ</label>
            <input type="text" name="depart" class="form-control" value="<?= $trajet['depart'] ?? '' ?>" required>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Date de départ</label>
            <input type="date" name="depart_date" class="form-control" min="<?= $now ?>" value="<?= isset($trajet['depart_date']) ? date('Y-m-d', strtotime($trajet['depart_date'])) : '' ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Destination</label>
            <input type="text" name="destination" class="form-control" value="<?= $trajet['destination'] ?? '' ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Date d'arrivée</label>
            <input type="date" name="destination_date" class="form-control" min="<?= isset($trajet['depart_date']) ? date('Y-m-d', strtotime($trajet['depart_date'])) : $now ?>" value="<?= isset($trajet['destination_date']) ? date('Y-m-d', strtotime($trajet['destination_date'])) : '' ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Places disponibles</label>
            <input type="number" name="places" class="form-control" value="<?= $trajet['places'] ?? '1' ?>" min="1" required>
        </div>

        <button type="submit" class="btn btn-primary">
            <?= (isset($id) && $id) ? 'Enregistrer les modifications' : 'Publier le trajet' ?>
        </button>
        <a href="/" class="btn btn-link">Annuler</a>
    </form>
</main>

<script>
const inputDepart = document.getElementById('date_depart');
const inputArrivee = document.getElementById('date_arrivee');

// Once the user selects a departure date, we set it as the minimum for the arrival date to prevent selecting an arrival before departure
inputDepart.addEventListener('change', function() {
    // Minimum arrival date must be the same as the departure date to prevent selecting an arrival before departure
    inputArrivee.min = inputDepart.value;
    
    // If the arrival date is already set and is before the new departure date, we reset it to match the departure date
    if (inputArrivee.value && inputArrivee.value < inputDepart.value) {
        inputArrivee.value = inputDepart.value;
    }
});

// Once the page is loaded (Useful in Edit Mode)
if (inputDepart.value) {
    inputArrivee.min = inputDepart.value;
}
</script>

<?php include 'footer.php'; ?>