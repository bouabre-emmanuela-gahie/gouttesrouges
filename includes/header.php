<?php
require_once __DIR__ . '/functions.php';
$pageTitle = $pageTitle ?? 'Gouttes Rouges';
$pageDescription = $pageDescription ?? 'Association ivoirienne engagée pour la santé menstruelle, l\'éducation et la dignité des filles et des femmes.';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <script>document.documentElement.classList.add("js");</script>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= e($pageTitle) ?></title>
  <meta name="description" content="<?= e($pageDescription) ?>">
  <link rel="icon" href="<?= e(asset('img/logo-icone.png')) ?>" type="image/png">
  <link rel="apple-touch-icon" href="<?= e(asset('img/logo-icone.png')) ?>">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= e(asset('css/style.css')) ?>">
</head>
<body>
<a class="skip-link" href="#contenu">Aller au contenu</a>
<header class="site-header">
  <div class="container header-inner">
    <a class="logo" href="<?= e(url('index.php')) ?>">
      <img src="<?= e(asset('img/logo.png')) ?>" alt="Gouttes Rouges" width="600" height="109">
    </a>
    <nav class="nav-main" aria-label="Navigation principale">
      <a class="<?= is_active('index.php') ?>" href="<?= e(url('index.php')) ?>">Accueil</a>
      <a class="<?= is_active('qui-sommes-nous.php') ?>" href="<?= e(url('qui-sommes-nous.php')) ?>">Qui sommes-nous ?</a>
      <a class="<?= is_active('nos-actions.php') ?>" href="<?= e(url('nos-actions.php')) ?>">Nos actions</a>
      <a class="<?= is_active('ressources.php') ?>" href="<?= e(url('ressources.php')) ?>">Ressources</a>
      <a class="<?= is_active('nous-soutenir.php') ?>" href="<?= e(url('nous-soutenir.php')) ?>">Nous soutenir</a>
      <a class="<?= is_active('contact.php') ?>" href="<?= e(url('contact.php')) ?>">Contact</a>
    </nav>
    <a class="btn btn-dark btn-don" href="<?= e(url('nous-soutenir.php')) ?>#don">Faire un don</a>
    <button class="nav-toggle" type="button" aria-label="Ouvrir le menu"><span></span></button>
  </div>
</header>
<main id="contenu">
<?php $flash = flash_get(); if ($flash): ?>
  <div class="container">
    <div class="flash flash-<?= e($flash['type']) ?>"><?= e($flash['message']) ?></div>
  </div>
<?php endif; ?>
