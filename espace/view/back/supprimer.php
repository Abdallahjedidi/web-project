<?php
require_once 'C:\xampp\htdocs\espace\controller\espaceController.php';


if (isset($_GET['idP']) && $_GET['idP'] != '') {
    $Pc = new espaceController();
    $Pc->deleteEspace(id: $_GET['idP']);
    header('Location: tables.php');
    exit();
}