<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Touche pas au Klaxon</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script> 
</head>
<body>
    <header>
        <nav>
            <h1>Touche pas au klaxon</h1>
            <div>
                //---------- ADMIN ----------
                <?php if (isset($role) && $role === 'admin'): ?>
                    <a href="index.php#utilisateurs" class="btn btn-outline-light">Utilisateurs</a>
                    <a href="index.php#agences" class="btn btn-outline-light">Agences</a>
                    <a href="index.php#trajets" class="btn btn-outline-light">Trajets</a>

                //---------- USER ---------- 
                <?php elseif (isset($role) && $role === 'user'): ?>
                    <a href="home.php" class="btn btn-outline-light">Créer un trajet</a>
                    <p>Bonjour, <?php echo isset($_SESSION['nom']) ? $_SESSION['nom'] : 'Utilisateur'; ?>!</p>
                
                //--------- GUEST ---------- 
                    <?php else : ?>
                        <a href="home.php" class="btn btn-outline-light">Voir les trajets</a>
                <?php endif; ?>

                <?php if(isset($_SESSION['role'])): ?>
                        <a href="home.php" class="btn btn-danger">Déconnexion</a>
                    <?php else: ?>
                        <a href="../routeur/login.php" class="btn btn-primary">Connexion</a>
                <?php endif; ?>
            </div>
        </nav>
    </header>