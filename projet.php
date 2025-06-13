<?php
// projet.php
session_start();
// Pas de protection par session : page publique

require_once __DIR__ . '/includes/config.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Gestion de projet – SAE23</title>
  <link rel="stylesheet" href="css/styles.css">
</head>
<body>
  <?php include __DIR__ . '/includes/header.php'; ?>

  <main class="container projet-page">
    <h1>Gestion de projet</h1>

    <!-- Objectifs du site -->
    <section>
      <h2>Objectif du site</h2>
      <p>
        Ce site a été développé dans le cadre du BUT Réseaux &amp; Télécommunications (IUT de Blagnac).
        Il permet de :
      </p>
      <ul>
        <li>Afficher sur la page d’accueil une description du site...</li>
        <li>Permettre à l’administrateur de gérer bâtiments, capteurs, etc.</li>
        <li>Donner accès aux gestionnaires de bâtiments (authentification, restreint aux données de leur bâtiment).</li>
        <li>Mettre à disposition une page de consultation publique des dernières mesures.</li>
        <li>Proposer une page de projet présentant les livrables et le suivi.</li>
      </ul>
    </section>

    <!-- GANTT final -->
    <section>
      <h2>GANTT final</h2>
      <p>Le diagramme de GANTT ci-dessous présente la planification des tâches du projet :</p>
      <figure>
        <img src="img/gant.png" alt="Diagramme de GANTT final" />
        <figcaption>Planification des livrables et jalons</figcaption>
      </figure>
      <p>Chaque barre représente une étape clé, ses durées estimées et ses interdépendances.</p>
    </section>

    <!-- Outils et plateformes -->
    <section>
      <h2>Outils et plateformes</h2>

      <!-- Node-RED -->
      <div class="subsection">
        <h3>Node-RED</h3>
        <p>
          <strong>Node-RED</strong> est un outil de développement par flux (flow-based)
          qui permet d’orchestrer et de transformer les flux de données MQTT entrants
          grâce à son interface graphique par « nœuds ».
        </p>
        <figure>
          <img src="img/Nodered.png" alt="Interface Node-RED" />
          <figcaption>Capture d’écran du flow Node-RED</figcaption>
        </figure>
      </div>

      <!-- Grafana -->
      <div class="subsection">
        <h3>Grafana</h3>
        <p>
          <strong>Grafana</strong> est utilisé pour la visualisation des données de capteurs.
          Nous avons configuré un dashboard pour surveiller en temps réel la température,
          l’humidité, la luminosité et le CO₂ dans chaque salle.
        </p>
        <figure>
          <img src="img/Grafana.png" alt="Dashboard Grafana" />
          <figcaption>Extrait de notre dashboard Grafana</figcaption>
        </figure>
      </div>

      <!-- GitHub -->
      <div class="subsection">
        <h3>GitHub</h3>
        <p>
          <strong>GitHub</strong> est une plateforme de gestion de code source (SCM) basée sur Git.
          Elle permet de :
        </p>
        <ul>
          <li>Travailler en équipe via branches et pull requests,</li>
          <li>Suivre l’historique des modifications,</li>
          <li>Gérer les tickets (issues) et les projets (projects),</li>
          <li>Publier la documentation via GitHub Pages.</li>
        </ul>
        <p>
          Nous avons hébergé notre dépôt de code sur GitHub pour centraliser le travail,
          garantir la traçabilité des commits et faciliter les revues de code.
        </p>
        <figure>
          <img src="img/github.png" alt="Capture d’écran GitHub" />
          <figcaption>Capture d’écran de notre dépôt sur GitHub</figcaption>
        </figure>
      </div>
    </section>

    <!-- Synthèses et retour d’expérience -->
    <section>
      <h2>Synthèse personnelle &amp; retours</h2>
      <article>
        <h3>Ethan</h3>
        <p>
          <strong>Travail réalisé :</strong> Développements PHP, mise en place de la base de données, configuration du serveur.<br>
          <strong>Problèmes rencontrés :</strong> Conflits de clé étrangère lors des suppressions en cascade.<br>
          <strong>Solutions :</strong> Ajout de contraintes ON DELETE CASCADE et ajustement des requêtes SQL.<br>
          <strong>Satisfaction :</strong> 90% du cahier des charges atteint, reste à mettre en place l'ajout/suppression.
        </p>
      </article>
      <article>
        <h3>Yasser</h3>
        <p>
          <strong>Travail réalisé :</strong> Intégration du CSS, responsive design.<br>
          <strong>Problèmes rencontrés :</strong> Compatibilité mobile et chevauchement de tableaux.<br>
          <strong>Solutions :</strong> CSS media queries.<br>
          <strong>Satisfaction :</strong> 85%, design à peaufiner.
        </p>
      </article>
      <article>
        <h3>Mathis</h3>
        <p>
          <strong>Travail réalisé :</strong> Gestion de projet, tests finaux.<br>
          <strong>Problèmes rencontrés :</strong> Génération de données de test et gestion des sessions.<br>
          <strong>Solutions :</strong> Scripts SQL batch et revue du système de sessions.<br>
          <strong>Satisfaction :</strong> 95%, scripts fiables et faciles à adapter.
        </p>
      </article>
    </section>

    <!-- Conclusion -->
    <section>
      <h2>Conclusion</h2>
      <p>
        Nous sommes globalement satisfaits du respect du cahier des charges :
        tous les modules essentiels fonctionnent et l’interface est opérationnelle.
        Les points d’amélioration restent l’optimisation  du site et l'ajout/suppression de bâtiments, de salles et de capteurs.
      </p>
    </section>
  </main>

  <?php include __DIR__ . '/includes/footer.php'; ?>
</body>
</html>
