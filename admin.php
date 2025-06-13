<?php
// admin.php

session_start();
// Si pas connecté ou pas admin, on renvoie vers login
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

// Chargement de la config et connexion PDO
require_once __DIR__ . '/includes/config.php';

// Récupération des Bâtiments
$stmt = $pdo->query("
    SELECT id_batiment, nom, login_gestionnaire, pswd_gestionnaire
    FROM batiments
    ORDER BY id_batiment
");
$batiments = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupération des Capteurs
$stmt = $pdo->query("
    SELECT nom_capteur, type, unite, nom_salle
    FROM capteurs
    ORDER BY nom_capteur
");
$capteurs = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupération des Salles
$stmt = $pdo->query("
    SELECT nom_salle, type, capacite, id_batiment
    FROM salles
    ORDER BY nom_salle
");
$salles = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupération des 20 dernières Mesures
$stmt = $pdo->prepare("
    SELECT id_mesure, valeur, date, horaire, nom_capteur
    FROM mesures
    ORDER BY id_mesure DESC
    LIMIT 20
");
$stmt->execute();
$mesures = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Administration complète</title>
  <link rel="stylesheet" href="css/styles.css">
</head>
<body>
  <?php include 'includes/header.php'; ?>

  <main class="container">
    <h1>Page d'administration complète</h1>

    <!-- Liste des Bâtiments -->
    <section>
      <h2>Liste des Bâtiments</h2>
      <a href="ajouter_batiment.php" class="btn">Ajouter un nouveau bâtiment</a>
      <table class="table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Login</th>
            <th>Mot de passe</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($batiments as $b): ?>
          <tr>
            <td><?= htmlspecialchars($b['id_batiment']) ?></td>
            <td><?= htmlspecialchars($b['nom']) ?></td>
            <td><?= htmlspecialchars($b['login_gestionnaire']) ?></td>
            <td><?= htmlspecialchars($b['pswd_gestionnaire']) ?></td>
            <td>
              <a href="modifier_batiment.php?id=<?= $b['id_batiment'] ?>">Modifier</a> |
              <a href="supprimer_batiment.php?id=<?= $b['id_batiment'] ?>"
                 onclick="return confirm('Supprimer ce bâtiment ?')">Supprimer</a>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </section>

    <!-- Liste des Capteurs -->
    <section>
      <h2>Liste des Capteurs</h2>
      <a href="ajouter_capteur.php" class="btn">Ajouter un capteur</a>
      <table class="table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Type</th>
            <th>Unité</th>
            <th>Salle</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($capteurs as $c): ?>
          <tr>
            <td><?= htmlspecialchars($c['id_capteur']) ?></td>
            <td><?= htmlspecialchars($c['nom_capteur']) ?></td>
            <td><?= htmlspecialchars($c['type']) ?></td>
            <td><?= htmlspecialchars($c['unite']) ?></td>
            <td><?= htmlspecialchars($c['nom_salle']) ?></td>
            <td>
              <a href="modifier_capteur.php?id=<?= $c['id_capteur'] ?>">Modifier</a> |
              <a href="supprimer_capteur.php?id=<?= $c['id_capteur'] ?>"
                 onclick="return confirm('Supprimer ce capteur ?')">Supprimer</a>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </section>

    <!-- Liste des Salles -->
    <section>
      <h2>Liste des Salles</h2>
      <a href="ajouter_salle.php" class="btn">Ajouter une salle</a>
      <table class="table">
        <thead>
          <tr>
            <th>Nom</th>
            <th>Type</th>
            <th>Capacité</th>
            <th>ID Bâtiment</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($salles as $s): ?>
          <tr>
            <td><?= htmlspecialchars($s['nom_salle']) ?></td>
            <td><?= htmlspecialchars($s['type']) ?></td>
            <td><?= htmlspecialchars($s['capacite']) ?></td>
            <td><?= htmlspecialchars($s['id_batiment']) ?></td>
            <td>
              <a href="modifier_salle.php?nom=<?= urlencode($s['nom_salle']) ?>">Modifier</a> |
              <a href="supprimer_salle.php?nom=<?= urlencode($s['nom_salle']) ?>"
                 onclick="return confirm('Supprimer cette salle ?')">Supprimer</a>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </section>

    <!-- 20 dernières Mesures -->
    <section>
      <h2>20 dernières Mesures</h2>
      <table class="table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Valeur</th>
            <th>Date</th>
            <th>Heure</th>
            <th>Nom capteur</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($mesures as $m): ?>
          <tr>
            <td><?= htmlspecialchars($m['id_mesure']) ?></td>
            <td><?= htmlspecialchars($m['valeur']) ?></td>
            <td><?= htmlspecialchars($m['date']) ?></td>
            <td><?= htmlspecialchars($m['horaire']) ?></td>
            <td><?= htmlspecialchars($m['nom_capteur']) ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </section>
  </main>

  <?php include 'includes/footer.php'; ?>
</body>
</html>
