<?php
require_once __DIR__ . '/functions.php';
$pageTitle = $pageTitle ?? 'Gouttes Rouges';
$pageDescription = $pageDescription ?? 'Association ivoirienne engagée pour la santé menstruelle, l\'éducation et la dignité des filles et des femmes.';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= e($pageTitle) ?></title>
  <meta name="description" content="<?= e($pageDescription) ?>">
  <link rel="icon" href="<?= e(asset('img/favicon.svg')) ?>" type="image/svg+xml">
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
      <svg viewBox="0 0 28 36" aria-hidden="true">
        <path d="M14 1.5C14 1.5 2.5 14.2 2.5 22.2a11.5 11.5 0 1 0 23 0C25.5 14.2 14 1.5 14 1.5z" fill="#b3122c"/>
        <path d="M14 13.2c.2 3.4 2.7 5.2 2.7 8.1A2.7 2.7 0 1 1 11.3 21c0-2.8 2.5-4.6 2.7-7.8z" fill="#fff" opacity=".35"/>
      </svg>
      Gouttes Rouges
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
