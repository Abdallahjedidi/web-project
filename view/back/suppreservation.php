<?php
require_once '../../controller/reserverC.php'; // Assure-toi que le contrôleur correspondant est bien inclus

// Vérifier si l'ID de la réservation est passé en paramètre
if (isset($_GET['id']) && $_GET['id'] != '') {
    $reservationController = new reserverController();

    // Supprimer la réservation
    $reservationController->deleteReserver($_GET['id']);

    // Rediriger vers la page des réservations (ou toute autre page de ton choix)
    header('Location: tables.php'); // Par exemple
    exit();
} else {
    // Si aucun ID n'est trouvé dans l'URL
    echo "Aucune réservation spécifiée.";
}
?>
