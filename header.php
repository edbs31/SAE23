<?php
// $pageTitle défini dans chaque page avant l'include
if (!isset($pageTitle)) $pageTitle = 'SAE23';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title><?php echo htmlspecialchars($pageTitle); ?></title>
  <link rel="stylesheet" href="css/styles.css">
</head>
<body>
  <header class="site-header">
    <h1><?php echo htmlspecialchars($pageTitle); ?></h1>
    <nav class="main-nav">
      <ul>
        <li><a href="index.php">Accueil</a></li>
        <li><a href="login.php">Administration</a></li>
        <li><a href="projet.php">Gestion de projet</a></li>
        <li><a href="gestion.php">Gestion</a></li>
        <li><a href="consultation.php">Consultation</a></li>
        <li><a href="logout.php">Déconnexion</a></li>
      </ul>
    </nav>
    <?php if (isset($_SESSION['user'])): ?>
      <p class="user-info">Connecté : <strong><?php echo htmlspecialchars($_SESSION['user']); ?></strong></p>
    <?php endif; ?>
  </header>
  <main class="site-content">
