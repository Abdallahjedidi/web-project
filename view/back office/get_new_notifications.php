<?php
session_start();
include_once '../../Controller/signalementctrl.php';

$signalementCtrl = new SignalementC();
$newSignalements = $signalementCtrl->getTodaySignalements();

// Filtrer pour ne PAS renvoyer ceux déjà fermés (cliqués sur X)
$result = [];

foreach ($newSignalements as $sig) {
    if (!isset($_SESSION['closed_notifications'][$sig['id_signalement']])) {
        $result[] = $sig;
    }
}

// Renvoyer la liste filtrée en JSON
header('Content-Type: application/json');
echo json_encode($result);
?>
