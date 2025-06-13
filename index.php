<?php
// includes/config.php contient les constantes de connexion à la BDD
require_once __DIR__ . '/includes/config.php';

// On inclut l’en-tête (navbar, CSS, etc.)
// Note : header.php doit juste afficher la nav, sans forcer la connexion
include __DIR__ . '/includes/header.php';
?>

<main class="container mt-4">
  <h1>Accueil</h1>

  <!-- Objectifs & Fonctionnalités -->
  <section class="my-5">
    <h2>Objectifs &amp; Fonctionnalités</h2>
    <ul>
      <li>Deux bâtiments gérés par un administrateur et chacun un gestionnaire</li>
      <li>Deux capteurs par bâtiment (température, humidité, etc.)</li>
      <li>Visualisation des données publiées sur un bus MQTT</li>
      <li>Dashboard Grafana pour les 4 capteurs</li>
      <li>Site web dynamique sous LAMPP, IHM conviviale</li>
      <li>Administration via formulaires (CRUD)</li>
    </ul>
  </section>

  <!-- Bâtiments gérés -->
  <section class="my-5">
    <h2>Bâtiments gérés</h2>
    <ul>
      <li><strong>Bâtiment E</strong> – Salle E100, Salle E105</li>
      <li><strong>Bâtiment B</strong> – Salle B001, Salle B101</li>
    </ul>
  </section>

  <!-- Salles équipées -->
  <section class="my-5">
    <h2>Salles équipées</h2>
    <ul>
      <li><strong>Salle E100</strong> – Capteurs de température et d’humidité</li>
      <li><strong>Salle E105</strong> – Capteurs de température et d’humidité</li>
      <li><strong>Salle B001</strong> – Capteurs de température et d’humidité</li>
      <li><strong>Salle B101</strong> – Capteurs de température et d’humidité</li>
    </ul>
  </section>
</main>

<?php
// inclusion du pied de page
include __DIR__ . '/includes/footer.php';
