<?php
session_start();
include_once '../../config.php';
include_once '../../model/User.php';
include_once '../../controller/UserController.php';

$error_message = '';
$success_message = '';

$UserController = new UserController();

if (isset($_POST['register'])) {
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    if (empty($nom) || empty($prenom) || empty($email) || empty($password)) {
        $error_message = "Tous les champs sont obligatoires.";
    } elseif ($password !== $password_confirm) {
        $error_message = "Les mots de passe ne correspondent pas.";
    } elseif ($UserController->isEmailTaken($email)) {
        $error_message = "Cet email est déjà utilisé.";
    } else {
        $user = new User(null, $nom, $prenom, $email, $password);
        $UserController->register($user);
        $success_message = "Inscription réussie.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(to right, #dfe9f3, #ffffff);
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .form-container {
            background: #ffffff;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 450px;
        }

        .form-container h2 {
            text-align: center;
            margin-bottom: 24px;
            color: #2c3e50;
        }

        label {
            font-weight: 600;
            color: #2c3e50;
        }

        .form-group {
            margin-bottom: 18px;
        }

        input {
            width: 100%;
            padding: 12px;
            margin-top: 6px;
            border: 1px solid #ddd;
            border-radius: 8px;
            transition: border 0.3s ease;
        }

        input:focus {
            outline: none;
            border-color: #3498db;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #2980b9;
        }

        .error, .success {
            text-align: center;
            margin-top: 15px;
            font-weight: 500;
        }

        .error {
            color: #e74c3c;
        }

        .success {
            color: #27ae60;
        }

        .link-login {
            margin-top: 20px;
            text-align: center;
        }

        .link-login a {
            color: #3498db;
            text-decoration: none;
            font-size: 14px;
        }

        .link-login a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="form-container">
        <h2>Inscription</h2>
        <form method="POST" action="register.php">
            <div class="form-group">
                <label for="nom">Nom</label>
                <input type="text" name="nom" id="nom" required>
            </div>

            <div class="form-group">
                <label for="prenom">Prénom</label>
                <input type="text" name="prenom" id="prenom" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required>
            </div>

            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" name="password" id="password" required>
            </div>

            <div class="form-group">
                <label for="password_confirm">Confirmer le mot de passe</label>
                <input type="password" name="password_confirm" id="password_confirm" required>
            </div>

            <button type="submit" name="register">S'inscrire</button>
        </form>

        <?php if (!empty($error_message)): ?>
            <div class="error"><?= $error_message ?></div>
        <?php endif; ?>

        <?php if (!empty($success_message)): ?>
            <div class="success"><?= $success_message ?></div>
            <script>
                // Stockage local + redirection vers profil
                const user = {
                    nom: <?= json_encode($nom) ?>,
                    prenom: <?= json_encode($prenom) ?>,
                    email: <?= json_encode($email) ?>,
                    role: 'user'
                };
                localStorage.setItem('user', JSON.stringify(user));
                setTimeout(() => {
                    window.location.href = 'profile.php';
                }, 1000);
            </script>
        <?php endif; ?>

        <div class="link-login">
            Déjà inscrit ? <a href="login.php">Se connecter</a>
        </div>
    </div>

</body>
</html>
