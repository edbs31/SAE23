<?php
// gestionnaire/login.php
session_start();
require_once __DIR__ . '/../includes/config.php';  // même config que pour admin

// Si formulaire soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'] ?? '';
    $pass  = $_POST['pass']  ?? '';

    // Prépare et exécute
    $stmt = $pdo->prepare("SELECT login_gestionnaire, pswd_gestionnaire, id_batiment FROM batiments WHERE login_gestionnaire = :lg AND pswd_gestionnaire = :pw");
    $stmt->execute(['lg' => $login, 'pw' => $pass]);
    $bat = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($bat) {
        // OK
        $_SESSION['login']      = $bat['login_gestionnaire'];
        $_SESSION['role']       = 'gestionnaire';
        $_SESSION['batiment_id']= $bat['id_batiment'];
        header('Location: ../gestion.php');
        exit;
    } else {
        $error = "Identifiants invalides";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Connexion Gestionnaire</title>
  <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
  <?php include __DIR__ . '/../includes/header.php'; ?>

  <main class="container">
    <h1>Connexion Gestionnaire</h1>
    <?php if (!empty($error)): ?>
      <p class="alert alert-danger"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <form method="post" class="form-card">
      <label>Login :</label>
      <input type="text" name="login" required autofocus>
      <label>Mot de passe :</label>
      <input type="password" name="pass" required>
      <button type="submit" class="btn">Se connecter</button>
    </form>
  </main>

  <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>
