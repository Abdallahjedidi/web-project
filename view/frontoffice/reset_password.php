<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Inclusions nécessaires
include_once '../../controller/UserController.php';
require_once '../../model/User.php'; // Inclure le modèle User si nécessaire

// Récupérer les données JSON envoyées par JavaScript
$data = json_decode(file_get_contents("php://input"), true);

$email = $data['email'];
$response = array('success' => false, 'message' => '');

// Vérifier si l'email existe dans la base de données
$userController = new UserController();
$user = $userController->getOneUserByEmail($email);

if ($user) {
    // Générer un mot de passe aléatoire
    $newPassword = generateRandomPassword(8);

    // Mettre à jour le mot de passe dans la base de données
    $userController->updateUserPassword($email, $newPassword);

    $response['success'] = true;
    $response['newPassword'] = $newPassword;
    $response['message'] = "Mot de passe réinitialisé avec succès.";
} else {
    $response['message'] = "Cet email n'existe pas dans nos enregistrements.";
}

header('Content-Type: application/json');
echo json_encode($response);

// Fonction pour générer un mot de passe aléatoire
function generateRandomPassword($length = 8) {
    return substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, $length);
}
?>
