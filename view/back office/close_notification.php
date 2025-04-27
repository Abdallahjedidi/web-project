<?php
session_start();

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $_SESSION['closed_notifications'][$id] = true;
}
?>
