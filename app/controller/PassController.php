<?php

namespace app\controller;

class PassController { 

    /**
     * Handle first-time password creation (password step)
     */
    public function createPassword(): void {
        // If the user tries to access this page without going through the login step, we redirect them to the login page
        if (!isset($_SESSION['temp_user'])) {
            header('Location: /login');
            exit();
        }

        // We retrieve the temporary user information stored during the login step
        $user = $_SESSION['temp_user'];
        $error = null;

        // -------------------------------- //
        //        PASSWORD CREATION         //
        // -------------------------------- //
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

                header('Location: /'); // Redirecting to the home page after successful password creation
                exit();
            }
        }

        // Include the password creation view template
        include __DIR__ . '/../../templates/password.php';
    }

    /**
     * Handle password verification (check_password step)
     */
    public function checkPassword(): void {
        // If the user tries to access this page without going through the login step, we redirect them to the login page
        if (!isset($_SESSION['temp_user'])) {
            header('Location: /login');
            exit();
        }

        // We retrieve the temporary user information stored during the login step
        $user = $_SESSION['temp_user'];
        $error = null;

        // -------------------------------- //
        //        PASSWORD CHECK            //
        // -------------------------------- //
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

                header('Location: /'); // Redirecting to the home page after successful login
                exit();
            } else {
                $error = "Mot de passe incorrect.";
            }
        }

        // Include the password checking view template
        include __DIR__ . '/../../templates/check_password.php';
    }
}