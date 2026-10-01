<?php
$pageTitle = 'Mentions légales — Gouttes Rouges';
require __DIR__ . '/includes/header.php';
?>
<section class="section">
  <div class="container prose">
    <h1>Mentions légales</h1>
    <p>Le site Gouttes Rouges est édité par l'association Gouttes Rouges, dont le siège est situé à Cocody, Abidjan, Côte d'Ivoire.</p>
    <p>Contact : <?= e(SITE_EMAIL) ?> — <?= e(SITE_PHONE) ?></p>
    <p>Directeur de la publication : Aminata Koné, présidente de l'association.</p>
    <p>Hébergement : à renseigner lors de la mise en ligne. Développement local prévu sous XAMPP (Apache, PHP, MySQL).</p>
    <p>Les contenus (textes, visuels, marques) sont la propriété de Gouttes Rouges, sauf mention contraire. Toute reproduction non autorisée est interdite.</p>
  </div>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
