<?php include 'header.php'; ?>

<?php if (isset($error) && $error !== null): ?>
    <div class="alert alert-danger mt-3 fw-bold">
        <?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>

<main>
    <div class="container mt-4">
        <h1>Agence</h1>

        <!-- ---------- ADMIN ----------- -->
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
           <h2><?= isset($agence) ? 'Modifier l\'agence' . ' de ' . $agence['nom'] : 'Créer l\'agence' ?></h2>
            <form method="POST" action="/agency/create">
                <div class="mb-3">
                    <label for="nom" class="form-label">Nom de l'agence</label>
                    <input type="text" class="form-control" id="nom" name="nom" required>
                </div>
                <button type="submit" class="btn btn-primary">
                    <?= isset($agence) ? 'Modifier l\'agence' : 'Créer l\'agence' ?>
                </button>
            </form>

            <h2>Liste des agences</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($agences) && !empty($agences)): ?>
                        <?php foreach ($agences as $agence): ?>
                            <tr>
                                <td><?= htmlspecialchars($agence['id']) ?></td>
                                <td><?= htmlspecialchars($agence['nom']) ?></td>
                                <td>
                                    <a href="/agency/<?= $agence['id'] ?>/edit" class="btn btn-sm btn-primary">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a href="/agency/<?= $agence['id'] ?>/delete" class="btn btn-sm btn-danger" 
                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette agence ?')">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>    
                            <td colspan="4" class="text-center">Aucune agence trouvée.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Vous n'avez pas les permissions pour voir cette page.</p>
        <?php endif; ?>
    </div>
</main>