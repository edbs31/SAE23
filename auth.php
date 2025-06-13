<?php
session_start();
// Si pas connecté → page de login
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}
?>
