<?php
// gestion.php

session_start();
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'gestionnaire') {
    header('Location: /sae23/gestionnaire/login.php');
    exit;
}

require_once __DIR__ . '/includes/config.php';

// On récupère l'id du bâtiment du gestionnaire connecté
$stmtBat = $pdo->prepare("
    SELECT id_batiment
    FROM batiments
    WHERE login_gestionnaire = ?
");
$stmtBat->execute([ $_SESSION['login'] ]);
$idBat = $stmtBat->fetchColumn();

// 1) Les salles
$stmt = $pdo->prepare("
    SELECT nom_salle, type, capacite
    FROM salles
    WHERE id_batiment = ?
    ORDER BY nom_salle
");
$stmt->execute([ $idBat ]);
$salles = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 2) Les capteurs du bâtiment
$stmt = $pdo->prepare("
    SELECT nom_capteur, type, unite, nom_salle
    FROM capteurs
    WHERE nom_salle IN (SELECT nom_salle FROM salles WHERE id_batiment = ?)
    ORDER BY nom_capteur
");
$stmt->execute([ $idBat ]);
$capteurs = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 3) Les 20 dernières mesures
$stmt = $pdo->prepare("
    SELECT m.id_mesure, m.valeur, m.date, m.horaire, m.nom_capteur
    FROM mesures m
    JOIN capteurs c ON m.nom_capteur = c.nom_capteur
    JOIN salles s   ON c.nom_salle     = s.nom_salle
    WHERE s.id_batiment = ?
    ORDER BY m.id_mesure DESC
    LIMIT 20
");
$stmt->execute([ $idBat ]);
$mesures = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 4) Statistiques par salle
$stmt = $pdo->prepare("
    SELECT
      s.nom_salle,
      MIN(m.valeur) AS min_val,
      ROUND(AVG(m.valeur),1) AS avg_val,
      MAX(m.valeur) AS max_val
    FROM mesures m
    JOIN capteurs c ON m.nom_capteur = c.nom_capteur
    JOIN salles s   ON c.nom_salle     = s.nom_salle
    WHERE s.id_batiment = ?
    GROUP BY s.nom_salle
    ORDER BY s.nom_salle
");
$stmt->execute([ $idBat ]);
$stats = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Gestion bâtiment</title>
  <link rel="stylesheet" href="/sae23/css/styles.css">
</head>
<body>
  <?php include __DIR__ . '/includes/header.php'; ?>

  <main class="container">
    <h1>Tableau de bord Gestionnaire</h1>
    <h2>Salles du bâtiment <?= htmlspecialchars($idBat === '1' ? 'E' : 'B') ?></h2>
    <table class="table">
      <thead><tr>
        <th>Nom</th><th>Type</th><th>Capacité</th>
      </tr></thead>
      <tbody>
        <?php foreach ($salles as $s): ?>
        <tr>
          <td><?= htmlspecialchars($s['nom_salle']) ?></td>
          <td><?= htmlspecialchars($s['type']) ?></td>
          <td><?= htmlspecialchars($s['capacite']) ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <h2>Capteurs du bâtiment <?= htmlspecialchars($idBat === '1' ? 'E' : 'B') ?></h2>
    <table class="table">
      <thead><tr>
        <th>Nom</th><th>Type</th><th>Unité</th><th>Salle</th>
      </tr></thead>
      <tbody>
        <?php foreach ($capteurs as $c): ?>
        <tr>
          <td><?= htmlspecialchars($c['nom_capteur']) ?></td>
          <td><?= htmlspecialchars($c['type']) ?></td>
          <td><?= htmlspecialchars($c['unite']) ?></td>
          <td><?= htmlspecialchars($c['nom_salle']) ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <h2>20 dernières Mesures</h2>
    <table class="table">
      <thead><tr>
        <th>ID</th><th>Valeur</th><th>Date</th><th>Heure</th><th>Capteur</th>
      </tr></thead>
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

    <!-- NOUVELLE SECTION STATISTIQUES -->
    <h2>Statistiques par salle</h2>
    <table class="table">
      <thead><tr>
        <th>Salle</th><th>Valeur min</th><th>Moyenne</th><th>Valeur max</th>
      </tr></thead>
      <tbody>
        <?php foreach ($stats as $st): ?>
        <tr>
          <td><?= htmlspecialchars($st['nom_salle']) ?></td>
          <td><?= htmlspecialchars($st['min_val']) ?></td>
          <td><?= htmlspecialchars($st['avg_val']) ?></td>
          <td><?= htmlspecialchars($st['max_val']) ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </main>

  <?php include __DIR__ . '/includes/footer.php'; ?>
</body>
</html>
