<?php
session_start();
require_once __DIR__ . '/includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $login = $_POST['login'] ?? '';
  $mdp   = $_POST['mdp']   ?? '';

  $stmt = $pdo->prepare("
    SELECT login, mdp, 'admin' AS role
      FROM administration
    UNION
    SELECT login_gestionnaire AS login, pswd_gestionnaire AS mdp, 'gest' AS role
      FROM batiments
    WHERE login_gestionnaire = :login AND pswd_gestionnaire = :mdp
      OR login_gestionnaire = :login AND pswd_gestionnaire = :mdp
  ");
  $stmt->execute([':login'=>$login,':mdp'=>$mdp]);
  $user = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($user) {
    $_SESSION['login'] = $user['login'];
    $_SESSION['role']  = $user['role'];
    // redirige suivant le rôle
    if ($user['role'] === 'admin') {
      header('Location: admin.php');
    } else {
      header('Location: gestionnaire.php');
    }
    exit;
  } else {
    $error = "Login / mot de passe incorrect.";
  }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Connexion Administrateur</title>
  <link rel="stylesheet" href="css/styles.css">
</head>
<body>
  <?php include 'includes/header.php'; ?>

  <main class="container">
    <h1>Connexion Administrateur</h1>

    <?php if ($error): ?>
      <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post" action="login.php">
      <label>
        Login :
        <input type="text" name="login" required>
      </label>
      <label>
        Mot de passe :
        <input type="password" name="password" required>
      </label>
      <button type="submit">Se connecter</button>
    </form>
  </main>

  <?php include 'includes/footer.php'; ?>
</body>
</html>
