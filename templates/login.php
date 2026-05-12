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

    if ($user) {
        // Storing the user information in a temporary session variable for the next step (password verification or creation)
        $_SESSION['temp_user'] = $user;
        
        // Verifying if the user already has a password set (first access or not)
        if (!empty($user['password'])) {
            // Redirecting to the password verification page if the user already has a password (not first access)
            header('Location: check_password.php'); 
        } else {
            // Redirecting to the password creation page if it's the user's first access (no password set yet)
            header('Location: password.php');
        }
        exit();
    } else {
        $error = "Cet email n'est pas reconnu par le système RH.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UserLogin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script> 
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