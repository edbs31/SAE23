<?php
// includes/config.php

// mes constantes
define('DB_HOST','localhost');
define('DB_NAME','sae23');
define('DB_USER','root');
define('DB_PASS','');

// on instancie $pdo, utilisable partout
try {
  $pdo = new PDO(
    'mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8',
    DB_USER,
    DB_PASS,
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
  );
} catch (PDOException $e) {
  die("Erreur BDD : " . $e->getMessage());
}
