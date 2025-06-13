<?php
// consultation.php

require_once __DIR__ . '/includes/config.php';

// Pour chaque capteur on va chercher sa dernière mesure
$sql = "
  SELECT
    c.nom_capteur,
    c.type,
    c.unite,
    m.valeur   AS derniere_valeur,
    m.date     AS date_mesure,
    m.horaire  AS heure_mesure
  FROM capteurs c
  LEFT JOIN (
    -- sous‐requête qui isole la dernière mesure de chaque capteur
    SELECT
      nom_capteur,
      valeur,
      date,
      horaire
    FROM mesures
    WHERE (nom_capteur, id_mesure) IN (
      SELECT
        nom_capteur,
        MAX(id_mesure)
      FROM mesures
      GROUP BY nom_capteur
    )
  ) m USING (nom_capteur)
  ORDER BY c.nom_capteur
";

$stmt = $pdo->query($sql);
$dernieres = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Consultation publique</title>
  <link rel="stylesheet" href="css/styles.css">
</head>
<body>
  <?php include 'includes/header.php'; ?>

  <main class="container">
    <h1>Consultation des dernières mesures des capteurs</h1>
    <form method="post">
      <button type="submit" name="rafraichir" class="btn">Rafraîchir</button>
    </form>

    <table class="table">
      <thead>
        <tr>
          <th>Capteur</th>
          <th>Type</th>
          <th>Unité</th>
          <th>Dernière Valeur</th>
          <th>Date</th>
          <th>Heure</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($dernieres as $d): ?>
        <tr>
          <td><?= htmlspecialchars($d['nom_capteur']) ?></td>
          <td><?= htmlspecialchars($d['type']) ?></td>
          <td><?= htmlspecialchars($d['unite']) ?></td>
          <td>
            <?= $d['derniere_valeur'] !== null
                ? htmlspecialchars($d['derniere_valeur'])
                : '<em>—</em>'
            ?>
          </td>
          <td>
            <?= $d['date_mesure'] !== null
                ? htmlspecialchars($d['date_mesure'])
                : '<em>—</em>'
            ?>
          </td>
          <td>
            <?= $d['heure_mesure'] !== null
                ? htmlspecialchars($d['heure_mesure'])
                : '<em>—</em>'
            ?>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </main>

  <?php include 'includes/footer.php'; ?>
</body>
</html>
