<?php
$pageTitle = 'Plan du site — Gouttes Rouges';
require __DIR__ . '/includes/header.php';
?>
<section class="section">
  <div class="container prose">
    <h1>Plan du site</h1>
    <ul>
      <li><a href="<?= e(url('index.php')) ?>">Accueil</a></li>
      <li><a href="<?= e(url('qui-sommes-nous.php')) ?>">Qui sommes-nous ?</a></li>
      <li><a href="<?= e(url('nos-actions.php')) ?>">Nos actions</a></li>
      <li><a href="<?= e(url('ressources.php')) ?>">Ressources</a></li>
      <li><a href="<?= e(url('nous-soutenir.php')) ?>">Nous soutenir</a></li>
      <li><a href="<?= e(url('contact.php')) ?>">Contact</a></li>
      <li><a href="<?= e(url('mentions-legales.php')) ?>">Mentions légales</a></li>
      <li><a href="<?= e(url('politique-confidentialite.php')) ?>">Politique de confidentialité</a></li>
      <li><a href="<?= e(url('conditions-utilisation.php')) ?>">Conditions d'utilisation</a></li>
      <li><a href="<?= e(url('admin/login.php')) ?>">Espace administration</a></li>
    </ul>
  </div>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
