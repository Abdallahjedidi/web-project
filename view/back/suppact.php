<?php
require_once '../../controller/activiteC.php';


if (isset($_GET['id']) && $_GET['id'] != '') {
    $Pc = new activiteController();
    $Pc->deleteActivite(id: $_GET['id']);
    header('Location: tables.php');
    exit();
}