<?php
include_once '../../Controller/SuiviC.php';
include_once '../../config.php';

if (isset($_GET['id_suivi'])) {
    $suivic = new SuiviC();
    $suivic->supprimerSuivi($_GET['id_suivi']);
}

header('Location: affichesuivi.php');
exit();
?>
