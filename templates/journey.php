<?php include 'header.php'; ?>

<?php
/** @var array $agences */
/** @var array|null $user */
/** @var array|null $trajet */
?>

<?php
if (!isset($now)) {
    $now = date('Y-m-d');
}
?>

<main class="container mt-5">
    <h1><?= (isset($id) && $id) ? 'Modifier le trajet' : 'Proposer un trajet' ?></h1>
    
    <form method="POST" class="col-md-6 shadow p-4 rounded bg-light">
        <div class="mb-3">
            <label for="depart" class="form-label">Ville de départ</label>
            <select name="depart" id="depart" class="form-control" required>
                <option value="">-- Sélectionnez une ville de départ --</option>
                <?php foreach ($agences as $agence): ?>
                    <option value="<?php echo htmlspecialchars($agence['nom']); ?>" 
                        <?php echo (isset($trajet) && $trajet['depart'] === $agence['nom']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($agence['nom']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Date de départ</label>
            <input type="date" name="depart_date" class="form-control" min="<?= date('Y-m-d') ?>" value="<?= htmlspecialchars($trajet['depart_date'] ?? '') ?>" required>        
        </div>

        <div class="mb-3">
            <label class="form-label">Ville de Destination</label>
            <select name="destination" id="destination" class="form-control" required>
                <option value="">-- Sélectionnez une ville de destination --</option>
                <?php foreach ($agences as $agence): ?>
                    <option value="<?php echo htmlspecialchars($agence['nom']); ?>" 
                        <?php echo (isset($trajet) && $trajet['destination'] === $agence['nom']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($agence['nom']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Date d'arrivée</label>
            <input type="date" name="destination_date" class="form-control" value="<?= htmlspecialchars($trajet['destination_date'] ?? '') ?>" required>        
        </div>

        <div class="mb-3">
            <label class="form-label">Places disponibles</label>
            <input type="number" name="places" class="form-control" value="<?= htmlspecialchars($trajet['places'] ?? '1') ?>" min="1" required>
        </div>

        <button type="submit" class="btn btn-primary">
            <?= (isset($id) && $id) ? 'Enregistrer les modifications' : 'Publier le trajet' ?>
        </button>
        <a href="/" class="btn btn-link">Annuler</a>
    </form>

    <div class="col-md-4">
        <?php if (isset($user) && $user): ?>
            <div class="card shadow-sm border-primary">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">Utilisateur connecté</h5>
                </div>
                <div class="card-body">
                    <p class="mb-2"><strong>Prénom :</strong> <?php echo htmlspecialchars($user['prenom']); ?></p>
                    <p class="mb-2"><strong>Nom :</strong> <?php echo htmlspecialchars($user['nom']); ?></p>
                    <p class="mb-2"><strong>Contact :</strong> <?php echo htmlspecialchars($user['contact']); ?></p>
                    <p class="mb-0"><strong>Email :</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-warning">
                Aucun utilisateur connecté trouvé en session.
            </div>
        <?php endif; ?>
    </div>
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