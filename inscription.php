<?php
require_once __DIR__ . '/includes/functions.php';

$redirect = safe_redirect_target($_GET['redirect'] ?? $_POST['redirect'] ?? null);
if (current_user()) {
    redirect($redirect);
}

$errors = [];
$old = ['nom' => '', 'prenom' => '', 'email' => '', 'telephone' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old['nom'] = trim($_POST['nom'] ?? '');
    $old['prenom'] = trim($_POST['prenom'] ?? '');
    $old['email'] = trim($_POST['email'] ?? '');
    $password = (string) ($_POST['password'] ?? '');
    $telephone = read_phone();

    if (!csrf_ok()) {
        $errors[] = 'Session expirée. Merci de renvoyer le formulaire.';
    }
    if (!valid_name($old['nom']) || !valid_name($old['prenom'])) {
        $errors[] = 'Le nom et le prénom ne doivent contenir que des lettres.';
    }
    if (!filter_var($old['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Merci d\'indiquer un email valide.';
    }
    if ($telephone === null || $telephone === '') {
        $errors[] = 'Le numéro de téléphone doit contenir uniquement des chiffres (6 à 14).';
    } else {
        $old['telephone'] = $telephone;
    }
    if (mb_strlen($password) < 8) {
        $errors[] = 'Le mot de passe doit contenir au moins 8 caractères.';
    } elseif ($password !== ($_POST['password_confirm'] ?? '')) {
        $errors[] = 'Les deux mots de passe ne correspondent pas.';
    }

    $db = pdo();
    if (!$errors && !$db) {
        $errors[] = 'Les comptes sont momentanément indisponibles. Merci de réessayer plus tard.';
    }
    if (!$errors && db_one('SELECT id FROM utilisateurs WHERE email = ?', [$old['email']])) {
        $errors[] = 'Un compte existe déjà avec cet email. Connectez-vous.';
    }

    if (!$errors) {
        $id = db_exec(
            'INSERT INTO utilisateurs (nom, prenom, email, telephone, mot_de_passe) VALUES (?, ?, ?, ?, ?)',
            [$old['nom'], $old['prenom'], $old['email'], $telephone, password_hash($password, PASSWORD_DEFAULT)]
        );
        login_user(['id' => $id] + $old);
        flash_set('success', 'Bienvenue ' . $old['prenom'] . ', votre compte est créé.');
        redirect($redirect);
    }
}

$pageTitle = 'Créer un compte — Gouttes Rouges';
require __DIR__ . '/includes/header.php';
?>
<section class="section">
  <div class="container account-wrap">
    <form class="card account-card" method="post">
      <h1>Créer un compte</h1>
      <p class="lead">Votre compte vous permet de faire un don et de retrouver l'historique de vos dons.</p>
      <?php foreach ($errors as $error): ?>
        <div class="flash flash-error"><?= e($error) ?></div>
      <?php endforeach; ?>
      <?= csrf_field() ?>
      <input type="hidden" name="redirect" value="<?= e($redirect) ?>">
      <div class="grid-2">
        <div class="field"><label for="ins_nom">Nom</label><input id="ins_nom" name="nom" required <?= name_attrs() ?> value="<?= e($old['nom']) ?>" autocomplete="family-name"></div>
        <div class="field"><label for="ins_prenom">Prénom</label><input id="ins_prenom" name="prenom" required <?= name_attrs() ?> value="<?= e($old['prenom']) ?>" autocomplete="given-name"></div>
      </div>
      <div class="field"><label for="ins_email">Email</label><input id="ins_email" type="email" name="email" required value="<?= e($old['email']) ?>" autocomplete="email"></div>
      <?= phone_field('ins_tel', 'Téléphone', true, $old['telephone']) ?>
      <div class="grid-2">
        <div class="field"><label for="ins_pass">Mot de passe</label><input id="ins_pass" type="password" name="password" required minlength="8" autocomplete="new-password"></div>
        <div class="field"><label for="ins_pass2">Confirmer le mot de passe</label><input id="ins_pass2" type="password" name="password_confirm" required minlength="8" autocomplete="new-password"></div>
      </div>
      <button class="btn btn-dark" type="submit" style="width:100%">Créer mon compte</button>
      <p class="account-switch">Déjà inscrit ? <a href="<?= e(url('connexion.php?redirect=' . urlencode($redirect))) ?>">Se connecter</a></p>
    </form>
  </div>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
