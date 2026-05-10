<?php

session_start();
require_once __DIR__ . '/../core/Database.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Checking if the form is submitted
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $db = \core\Database::getConnection();
    
    // Searching for the user in the database
    $stmt = $db->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();


    if ($user && $password === $user['password']) {

        $_SESSION['role'] = $user['role'];
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['nom'] = $user['nom'];

        // Redirecting to the home page after successful login
        header('Location: index.php');
        exit();
    } else {
        $error = "Identifiants incorrects.";
    }
}
?>

<? include '../templates/header.php'; ?>

    <main>
        <h2>Connexion</h2>
        <?php if (isset($error)) echo "<p style='color:red'>$error</p>"; ?>
        <form method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <button type="submit">Se connecter</button>
        </form>
    </main>

<? include '../templates/footer.php'; ?>