<?php
require_once __DIR__ . '/includes/functions.php';
$slug = $_GET['slug'] ?? '';
$article = get_article($slug);
if (!$article) {
    http_response_code(404);
    $pageTitle = 'Article introuvable — Gouttes Rouges';
    require __DIR__ . '/includes/header.php';
    echo '<section class="section"><div class="container"><h1>Article introuvable</h1><p><a href="' . e(url('ressources.php')) . '">Retour aux ressources</a></p></div></section>';
    require __DIR__ . '/includes/footer.php';
    exit;
}
$pageTitle = $article['titre'] . ' — Gouttes Rouges';
$pageDescription = $article['extrait'] ?? excerpt($article['contenu'] ?? '', 160);
require __DIR__ . '/includes/header.php';
?>
<article class="section">
  <div class="container prose">
    <p class="eyebrow"><a href="<?= e(url('ressources.php')) ?>">Ressources</a> / <?= e($article['categorie'] ?? 'Article') ?></p>
    <h1><?= e($article['titre']) ?></h1>
    <p class="meta"><?= e($article['auteur'] ?? '') ?> · <?= e(format_date($article['date_publication'])) ?></p>
    <div class="media-frame" style="margin:24px 0">
      <img src="<?= e(asset($article['image'])) ?>" alt="">
    </div>
    <?= $article['contenu'] ?>
  </div>
</article>
<?php require __DIR__ . '/includes/footer.php'; ?>
