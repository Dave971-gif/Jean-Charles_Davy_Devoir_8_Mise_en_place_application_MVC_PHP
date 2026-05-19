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
    <h1>Connexion</h1>
    <p>Ravi de vous revoir, <strong><?php echo $user['prenom']; ?></strong> !</p>
    <p>Veuillez saisir votre mot de passe pour accéder au tableau de bord.</p>

    <form method="POST" class="col-md-4">
        <div class="mb-3">
            <input type="password" name="password" class="form-control" placeholder="Votre mot de passe" required autofocus>
        </div>
        <button type="submit" class="btn btn-primary">Se connecter</button>
        <a href="./password" class="btn btn-link">Mot de passe oublié ?</a>
    </form>

    <?php if ($error): ?>
        <p class="text-danger mt-3 fw-bold"><?php echo $error; ?></p>
    <?php endif; ?>
</main>

<?php include 'footer.php'; ?>