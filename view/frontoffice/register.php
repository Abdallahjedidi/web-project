<?php
session_start();
include_once '../../config.php';
include_once '../../model/User.php';
include_once '../../controller/UserController.php';

$error_messages = [];
$success_message = '';

$UserController = new UserController();

if (isset($_POST['register'])) {
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    if (empty($nom) || empty($prenom) || empty($email) || empty($password) || empty($password_confirm)) {
        $error_messages[] = "Tous les champs sont obligatoires.";
    }

    if (!preg_match('/^[a-zA-ZÀ-ÿ\s\-]+$/', $nom)) {
        $error_messages[] = "Le nom ne doit contenir que des lettres, espaces ou tirets.";
    }

    if (!preg_match('/^[a-zA-ZÀ-ÿ\s\-]+$/', $prenom)) {
        $error_messages[] = "Le prénom ne doit contenir que des lettres, espaces ou tirets.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_messages[] = "Veuillez entrer une adresse email valide.";
    }

    if (strlen($password) < 8) {
        $error_messages[] = "Le mot de passe doit contenir au moins 8 caractères.";
    }

    if ($password !== $password_confirm) {
        $error_messages[] = "Les mots de passe ne correspondent pas.";
    }

    if ($UserController->isEmailTaken($email)) {
        $error_messages[] = "Cet email est déjà utilisé.";
    }

    if (empty($error_messages)) {
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
    <link href="css/register.css" rel="stylesheet">
    <style>
        .error {
            background-color: #ffe0e0;
            color: #c0392b;
            padding: 10px;
            border-radius: 5px;
            margin-top: 15px;
        }
        .error ul {
            margin: 0;
            padding-left: 20px;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 5px;
            margin-top: 15px;
        }
    </style>
</head>
<body>

    <div class="form-container">
        <h2>Inscription</h2>
        <form method="POST" action="register.php">
            <div class="form-group">
                <label for="nom">Nom</label>
                <input type="text" name="nom" id="nom" value="<?= isset($nom) ? htmlspecialchars($nom) : '' ?>">
            </div>

            <div class="form-group">
                <label for="prenom">Prénom</label>
                <input type="text" name="prenom" id="prenom" value="<?= isset($prenom) ? htmlspecialchars($prenom) : '' ?>">
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="<?= isset($email) ? htmlspecialchars($email) : '' ?>">
            </div>

            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" name="password" id="password">
            </div>

            <div class="form-group">
                <label for="password_confirm">Confirmer le mot de passe</label>
                <input type="password" name="password_confirm" id="password_confirm">
            </div>

            <button type="submit" name="register">S'inscrire</button>
        </form>

        <?php if (!empty($error_messages)): ?>
            <div class="error">
                <ul>
                    <?php foreach ($error_messages as $msg): ?>
                        <li><?= htmlspecialchars($msg) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if (!empty($success_message)): ?>
            <div class="success"><?= $success_message ?></div>
            <script>
                const user = {
                    nom: <?= json_encode($nom) ?>,
                    prenom: <?= json_encode($prenom) ?>,
                    email: <?= json_encode($email) ?>,
                    role: 'user'
                };
                localStorage.setItem('user', JSON.stringify(user));
                setTimeout(() => {
                    window.location.href = 'home.html';
                }, 1000);
            </script>
        <?php endif; ?>

        <div class="link-login">
            Déjà inscrit ? <a href="login.php">Se connecter</a>
        </div>
    </div>

</body>
</html>
