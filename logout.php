<?php
// logout.php
session_start();

// on détruit TOUTES les variables de session
$_SESSION = [];

// si on utilise des cookies de session, on les efface aussi
if (ini_get("session.use_cookies")) {
    setcookie(
        session_name(),
        '',
        time() - 42000,
        '/',        // <— on précise bien la racine du domaine
        '',         // domaine (vide = domaine courant)
        false,      // secure
        true        // httponly
    );
}

// on détruit la session côté serveur
session_destroy();

// on redirige vers la page d'accueil publique (index.php de /sae23/)
header('Location: /sae23/index.php');
exit;

