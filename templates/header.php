<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Touche pas au Klaxon</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>

    <?php if (isset($_SESSION['flash'])): ?>
        <div class="alert alert-success">
            <?php 
                echo $_SESSION['flash']; 
                unset($_SESSION['flash']); // Clear the flash message after displaying it
            ?>
        </div>
    <?php endif; ?>
    
    <header>
        <nav>
            <div>
                <!-- ---------- ADMIN ---------- -->
                <?php if (isset($role) && $role === 'admin'): ?>
                    <h1><a href="index.php">Touche pas au klaxon</a></h1>
                    <a href="index.php#utilisateurs" class="btn ">Utilisateurs</a>
                    <a href="index.php#agences" class="btn ">Agences</a>
                    <a href="index.php#trajets" class="btn ">Trajets</a>
                    
                    <p>Bonjour, <?php echo $_SESSION['prenom'] ?? 'Administrateur'; ?> !</p>
                
                    <!-- ---------- USER ---------- -->
                <?php elseif (isset($role) && $role === 'user'): ?>
                    <h1>Touche pas au klaxon</h1>
                    <a href="templates/journey.php" class="btn">Créer un trajet</a>
                    <p>Bonjour, <?php echo $_SESSION['prenom'] ?? 'Utilisateur'; ?>!</p>
                
                         
                    <?php else : ?> 
                        <!-- ---------- GUEST ---------- -->
                        <h1>Touche pas au klaxon</h1>
                <?php endif; ?>

                <?php if(isset($_SESSION['role'])): ?>
                        <a href="templates/home.php" class="btn btn-danger">Déconnexion</a>
                    <?php else: ?>
                        <a href="templates/login.php" class="btn btn-primary">Connexion</a>
                <?php endif; ?>
            </div>
        </nav>
    </header>