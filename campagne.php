<?php
require_once __DIR__ . '/includes/functions.php';
$slug = $_GET['slug'] ?? '';
$campagne = get_campagne($slug);
if (!$campagne) {
    http_response_code(404);
    $pageTitle = 'Campagne introuvable — Gouttes Rouges';
    require __DIR__ . '/includes/header.php';
    echo '<section class="section"><div class="container"><h1>Campagne introuvable</h1><p><a href="' . e(url('nos-actions.php')) . '">Retour aux actions</a></p></div></section>';
    require __DIR__ . '/includes/footer.php';
    exit;
}
$pageTitle = $campagne['titre'] . ' — Gouttes Rouges';
$pageDescription = $campagne['description'] ?? '';
require __DIR__ . '/includes/header.php';
?>
<article class="section">
  <div class="container prose">
    <p class="eyebrow"><a href="<?= e(url('nos-actions.php')) ?>#campagnes">Campagnes</a></p>
    <h1><?= e($campagne['titre']) ?></h1>
    <p class="meta"><?= e(format_date($campagne['date_debut'])) ?><?= !empty($campagne['date_fin']) ? ' — ' . e(format_date($campagne['date_fin'])) : '' ?></p>
    <div class="media-frame" style="margin:24px 0">
      <img src="<?= e(asset($campagne['image'])) ?>" alt="">
    </div>
    <p><?= e($campagne['description']) ?></p>
    <?= $campagne['contenu'] ?? '' ?>
    <p style="margin-top:32px"><a class="btn btn-dark" href="<?= e(url('nous-soutenir.php')) ?>#don">Soutenir cette campagne</a></p>
  </div>
</article>
<?php require __DIR__ . '/includes/footer.php'; ?>
