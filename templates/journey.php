<?php include 'header.php'; ?>

<?php
/** @var array $agences */
/** @var array|null $user */
/** @var array|null $trajet */
?>

<main class="container mt-5">
    <div class="row">
        
        <div class="col-md-8">
            <h1 class="mb-4"><?= (isset($trajet) && $trajet) ? 'Modifier le trajet' : 'Proposer un trajet' ?></h1>
            
            <form method="POST" class="shadow p-4 rounded bg-light">
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
                    <label for="depart_date" class="form-label">Date de départ</label>
                    <input type="date" id="depart_date" name="depart_date" class="form-control" min="<?= date('Y-m-d') ?>" value="<?= htmlspecialchars($trajet['depart_date'] ?? '') ?>" required>        
                </div>

                <div class="mb-3">
                    <label for="destination" class="form-label">Ville de Destination</label>
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
                    <label for="destination_date" class="form-label">Date d'arrivée</label>
                    <input type="date" id="destination_date" name="destination_date" class="form-control" value="<?= htmlspecialchars($trajet['destination_date'] ?? '') ?>" required>        
                </div>

                <div class="mb-3">
                    <label class="form-label">Places disponibles</label>
                    <input type="number" name="places" class="form-control" value="<?= htmlspecialchars($trajet['places'] ?? '1') ?>" min="1" required>
                </div>

                <button type="submit" class="btn btn-primary">
                    <?= (isset($trajet) && $trajet) ? 'Enregistrer les modifications' : 'Publier le trajet' ?>
                </button>
                <a href="/" class="btn btn-link">Annuler</a>
            </form>
        </div>

        <div class="col-md-4 mt-5 mt-md-0">
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

    </div>
</main>

<script>
const selectDepart = document.getElementById('depart');
const selectDestination = document.getElementById('destination');
const inputDepart = document.getElementById('depart_date');
const inputArrivee = document.getElementById('destination_date');

// Similarity check for cities
function validerVilles() {
    if (selectDepart.value && selectDestination.value && selectDepart.value === selectDestination.value) {
        alert("La ville de départ et la destination ne peuvent pas être identiques !");
        selectDestination.value = ""; // Réinitialise la destination
    }
}
selectDepart.addEventListener('change', validerVilles);
selectDestination.addEventListener('change', validerVilles);


// Date management
inputDepart.addEventListener('change', function() {
    inputArrivee.min = inputDepart.value;
    if (inputArrivee.value && inputArrivee.value < inputDepart.value) {
        inputArrivee.value = inputDepart.value;
    }
});

if (inputDepart.value) {
    inputArrivee.min = inputDepart.value;
}
</script>

<?php include 'footer.php'; ?>