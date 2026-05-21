<?php
/** @var array $user Temporary user details provided by PassController */
/** @var string|null $error Feedback error message for the form */
?>

<?php 

if (!isset($user)) {
    $user = $_SESSION['temp_user'] ?? ['prenom' => 'Invité', 'nom' => ''];
}
if (!isset($error)) {
    $error = null;
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UserLogin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/public/style/style.css">
    <link rel="stylesheet" href="/public/style/login.css">
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
</head>
<body>
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