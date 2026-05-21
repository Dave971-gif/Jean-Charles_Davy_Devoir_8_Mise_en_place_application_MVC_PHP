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
    <main>
        <h1>Connexion</h1>
        <p>Veuillez saisir votre adresse email professionnelle pour continuer.</p>

        <form method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <button type="submit">Continuer</button>
        </form>

        <?php if (isset($error)): ?>
            <p style="color: red; font-weight: bold;">
                <?php echo $error; ?>
            </p>
        <?php endif; ?>
    </main>

<?php include 'footer.php'; ?>