<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Touche pas au Klaxon</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/public/style/style.css">
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
</head>
<body>

    <?php if (isset($_SESSION['flash'])): ?>
        <div class="alert alert-success">
            <?php 
                echo $_SESSION['flash']; 
                unset($_SESSION['flash']); 
            ?>
        </div>
    <?php endif; ?>
    
    <header>
        <nav class="navbar navbar-expand-lg p-3 bar-nav rounded-3">
            <div class="container-fluid">
                <?php if (isset($role) && $role === 'admin'): ?>
                    <h1><a href="./" class="text-white text-decoration-none">Touche pas au klaxon</a></h1>
                    <a href="./#utilisateurs" class="btn btn-secondary">Utilisateurs</a>
                    <a href="./#agences" class="btn btn-secondary">Agences</a>
                    <a href="./#trajets" class="btn btn-secondary">Trajets</a>
                    <p class="mb-0">Bonjour, <?php echo $_SESSION['prenom'] . ' ' . $_SESSION['nom'] ?? 'Administrateur'; ?> !</p>
                
                <?php elseif (isset($role) && $role === 'user'): ?>
                    <h1><a href="/" class="text-white text-decoration-none">Touche pas au klaxon</a></h1>
                    <a href="./journey/create" class="btn btn-secondary">Créer un trajet</a>
                    <p class="mb-0">Bonjour, <?php echo $_SESSION['prenom'] . ' ' . $_SESSION['nom'] ?? 'Utilisateur'; ?>!</p>
                
                <?php else : ?> 
                    <h1><a href="/" class="text-white text-decoration-none">Touche pas au klaxon</a></h1>
                <?php endif; ?>

                <?php if(isset($_SESSION['role'])): ?>
                    <a href="./?action=logout" class="btn btn-danger">Déconnexion</a>
                <?php else: ?>
                    <a href="./login" class="btn btn-primary">Connexion</a>
                <?php endif; ?>
            </div>
        </nav>
    </header>