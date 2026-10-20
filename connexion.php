<?php
require_once __DIR__ . '/includes/functions.php';

$redirect = safe_redirect_target($_GET['redirect'] ?? $_POST['redirect'] ?? null);
if (current_user()) {
    redirect($redirect);
}

$error = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = (string) ($_POST['password'] ?? '');
    if (!csrf_ok()) {
        $error = 'Session expirée. Merci de réessayer.';
    } else {
        $user = db_one('SELECT * FROM utilisateurs WHERE email = ?', [$email]);
        if ($user && password_verify($password, $user['mot_de_passe'])) {
            login_user($user);
            flash_set('success', 'Bonjour ' . $user['prenom'] . ', vous êtes connecté(e).');
            redirect($redirect);
        }
        $error = 'Email ou mot de passe incorrect.';
    }
}

$pageTitle = 'Se connecter — Gouttes Rouges';
require __DIR__ . '/includes/header.php';
?>
<section class="section">
  <div class="container account-wrap">
    <form class="card account-card" method="post">
      <h1>Se connecter</h1>
      <p class="lead">Connectez-vous pour faire un don et suivre vos contributions.</p>
      <?php if ($error): ?><div class="flash flash-error"><?= e($error) ?></div><?php endif; ?>
      <?= csrf_field() ?>
      <input type="hidden" name="redirect" value="<?= e($redirect) ?>">
      <div class="field"><label for="cx_email">Email</label><input id="cx_email" type="email" name="email" required value="<?= e($email) ?>" autocomplete="email"></div>
      <div class="field"><label for="cx_pass">Mot de passe</label><input id="cx_pass" type="password" name="password" required autocomplete="current-password"></div>
      <button class="btn btn-dark" type="submit" style="width:100%">Se connecter</button>
      <p class="account-switch">Pas encore de compte ? <a href="<?= e(url('inscription.php?redirect=' . urlencode($redirect))) ?>">Créer un compte</a></p>
    </form>
  </div>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
