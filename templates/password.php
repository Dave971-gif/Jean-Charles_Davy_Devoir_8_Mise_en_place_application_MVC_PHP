<?php
session_start();

require_once __DIR__ . '/../vendor/autoload.php';

// If the user tries to access this page without going through the login step, we redirect them to the login page
if (!isset($_SESSION['temp_user'])) {
    header('Location: login.php');
    exit();
}

// We retrieve the temporary user information stored during the login step
$user = $_SESSION['temp_user'];
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm'] ?? '';

    if (empty($password) || strlen($password) < 4) {
        $error = "Le mot de passe doit faire au moins 4 caractères.";
    } elseif ($password !== $confirm) {
        $error = "Les mots de passe ne correspondent pas.";
    } else {
        // Hash the password using a secure algorithm (bcrypt by default)
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Saving the hashed password in the database for this user
        $db = \core\Database::getConnection();
        $stmt = $db->prepare("UPDATE users SET password = :pw WHERE id = :id");
        $stmt->execute([
            'pw' => $hashedPassword,
            'id' => $user['id']
        ]);

        // Success: password is valid and confirmed, we can finalize the session setup
        // Stocking the hashed password and user info in the session for future use
        $_SESSION['hashed_password'] = password_hash($password, PASSWORD_DEFAULT);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['nom'] = $user['nom'];
        $_SESSION['prenom'] = $user['prenom'];
        $_SESSION['contact'] = $user['contact'];
        $_SESSION['email'] = $user['email'];
        
        // Setting the role based on the email, this is a simple way to differentiate admins from regular users
        $admins = ['alexandre.martin@email.fr', 'sophie.dubois@email.fr'];
        $_SESSION['role'] = in_array($user['email'], $admins) ? 'admin' : 'user';

        // Cleaning up the temporary user data used for this step
        unset($_SESSION['temp_user']);
        
        $_SESSION['flash'] = "Votre mot de passe a été enregistré avec succès !";

        header('Location: ../index.php');
        exit();
    }
}
?>

<?php include '../templates/header.php'; ?>

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

<?php include '../templates/footer.php'; ?>