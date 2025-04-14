<?php
session_start();
include_once '../../config.php';
include_once '../../model/User.php';
include_once '../../controller/usercontroller.php';

$error_message = '';
$success_message = '';

$UserController = new UserController();


if (isset($_POST['login'])) {
    $email = trim($_POST['email_login']);
    $password = $_POST['password_login'];

    if (empty($email) || empty($password)) {
        $error_message = "Veuillez remplir tous les champs de connexion.";
    } else {
        // Assure-toi que $UserController existe bien, par exemple :
        $UserController = new UserController();
        
        $user = $UserController->getOneUserByEmail($email);
        if ($user && password_verify($password, $user['password'])) {
            // Démarrage de la session côté serveur
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_role'] = $user['role'];
            $_SESSION['user_nom'] = $user['nom'];

            // Récupération de toutes les informations de l'utilisateur pour localStorage
            $userData = [
                'id'       => $user['id'],
                'nom'      => $user['nom'],
                'prenom'   => $user['prenom'],
                'email'    => $user['email'],
                'role'     => $user['role']
            ];
            // Conversion en JSON pour le JavaScript
            $userJson = json_encode($userData);
            
            if ($user['role'] === 'admin') {
                echo "<script>
                        localStorage.setItem('user', '$userJson');
                        window.location.href = '../../view/backoffice/index.html';
                      </script>";
            } else {
                echo "<script>
                        localStorage.setItem('user', '$userJson');
                        window.location.href = 'home.html';
                      </script>";
            }
            exit;
            
        } else {
            $error_message = "Email ou mot de passe incorrect.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link href="css/login.css" rel="stylesheet">

    
</head>
<body>

    <div class="form-container">
        <h2>Connexion</h2>
        <form method="POST" action="login.php">
            <div class="form-group">
                <label for="email_login">Email</label>
                <input type="email" name="email_login" id="email_login" placeholder="ex: nom@domaine.com">
            </div>

            <div class="form-group">
                <label for="password_login">Mot de passe</label>
                <input type="password" name="password_login" id="password_login" placeholder="••••••••">
            </div>

            <button type="submit" name="login">Se connecter</button>
        </form>

        <?php if (!empty($error_message)): ?>
            <div class="error"><?= $error_message ?></div>
        <?php endif; ?>

        <?php if (!empty($success_message)): ?>
            <div class="success"><?= $success_message ?></div>
        <?php endif; ?>

        <div class="link-register">
            Pas encore inscrit ? <a href="register.php">Créer un compte</a>
        </div>
    </div>

</body>
</html>