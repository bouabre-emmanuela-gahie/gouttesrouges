<?php
if (!isset($adminTitle)) {
    $adminTitle = 'Administration';
}
$user = admin_user();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= e($adminTitle) ?> — Admin</title>
  <link rel="stylesheet" href="<?= e(asset('css/style.css')) ?>">
</head>
<body class="admin-body">
<div class="admin-shell">
  <aside class="admin-side">
    <strong>Gouttes Rouges</strong>
    <p style="color:#9aa3b2;font-size:.85rem">Tableau de bord</p>
    <nav>
      <a class="<?= admin_nav('index.php') ?>" href="<?= e(url('admin/index.php')) ?>">Tableau de bord</a>
      <a class="<?= admin_nav('articles.php') ?>" href="<?= e(url('admin/articles.php')) ?>">Articles</a>
      <a class="<?= admin_nav('campagnes.php') ?>" href="<?= e(url('admin/campagnes.php')) ?>">Campagnes</a>
      <a class="<?= admin_nav('dons.php') ?>" href="<?= e(url('admin/dons.php')) ?>">Dons</a>
      <a class="<?= admin_nav('messages.php') ?>" href="<?= e(url('admin/messages.php')) ?>">Messages</a>
      <a class="<?= admin_nav('partenaires.php') ?>" href="<?= e(url('admin/partenaires.php')) ?>">Partenaires</a>
      <a href="<?= e(url('index.php')) ?>">Voir le site</a>
      <a href="<?= e(url('admin/logout.php')) ?>">Déconnexion</a>
    </nav>
    <p style="margin-top:24px;color:#9aa3b2;font-size:.8rem"><?= e(($user['prenom'] ?? '') . ' ' . ($user['nom'] ?? '')) ?></p>
  </aside>
  <div class="admin-main">
    <h1><?= e($adminTitle) ?></h1>
