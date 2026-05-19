<?php
/** @var array $user Temporary user details provided by PassController */
/** @var string|null $error Feedback error message for the form */
?>

<?php 

include 'header.php'; 

if (!isset($user)) {
    $user = $_SESSION['temp_user'] ?? ['prenom' => 'Invité', 'nom' => ''];
}
if (!isset($error)) {
    $error = null;
}

?>

<main class="container mt-5">
    <h1>Finaliser la connexion</h1>
    <p>Bonjour <strong><?php echo $user['prenom']; ?></strong>, créez un mot de passe pour votre session.</p>

    <form method="POST" class="col-md-4">
        <div class="mb-3">
            <input type="password" name="password" class="form-control" placeholder="Nouveau mot de passe" required>
        </div>
        <div class="mb-3">
            <input type="password" name="confirm" class="form-control" placeholder="Confirmez le mot de passe" required>
        </div>
        <button type="submit" class="btn btn-success">Activer ma session</button>
    </form>

    <?php if ($error): ?>
        <p class="text-danger mt-3 fw-bold"><?php echo $error; ?></p>
    <?php endif; ?>
</main>

<?php include 'footer.php'; ?>