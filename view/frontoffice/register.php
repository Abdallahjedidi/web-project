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
    <link href="css/register.css" rel="stylesheet">


</head>
<body>

    <div class="form-container">
        <h2>Inscription</h2>
        <form method="POST" action="register.php">
            <div class="form-group">
                <label for="nom">Nom</label>
                <input type="text" name="nom" id="nom" >
            </div>

            <div class="form-group">
                <label for="prenom">Prénom</label>
                <input type="text" name="prenom" id="prenom" >
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" >
            </div>

            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" name="password" id="password" >
            </div>

            <div class="form-group">
                <label for="password_confirm">Confirmer le mot de passe</label>
                <input type="password" name="password_confirm" id="password_confirm" >
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
