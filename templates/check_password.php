<?php

// If the user tries to access this page without going through the login step, we redirect them to the login page
if (!isset($_SESSION['temp_user'])) {
    header('Location: ./login');
    exit();
}

$user = $_SESSION['temp_user'];
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'] ?? '';

    // Verifying the password using the password_verify function, 
    // which compares the entered password with the hashed password stored in the database
    if (password_verify($password, $user['password'])) {
        
        // Success: password is correct, we can finalize the session setup
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['nom'] = $user['nom'];
        $_SESSION['prenom'] = $user['prenom'];
        $_SESSION['email'] = $user['email'];
        
        // Defining the role based on the email, this is a simple way to differentiate admins from regular users
        $admins = ['alexandre.martin@email.fr', 'sophie.dubois@email.fr'];
        $_SESSION['role'] = in_array($user['email'], $admins) ? 'admin' : 'user';

        // Cleaning up the temporary user data used for this step
        unset($_SESSION['temp_user']);

        header('Location: ./'); // Redirecting to the home page after successful login
        exit();
    } else {
        $error = "Mot de passe incorrect.";
    }
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