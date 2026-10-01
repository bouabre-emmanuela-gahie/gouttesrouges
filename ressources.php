<?php
require_once __DIR__ . '/includes/icons.php';
$pageTitle = 'Ressources — Gouttes Rouges';
$pageDescription = 'Articles, guides, FAQ, supports éducatifs, statistiques et glossaire sur la santé menstruelle.';
require __DIR__ . '/includes/header.php';

$articles = get_articles();
$faq = get_faq();
$supports = get_supports();
$glossaire = get_glossaire();
$chiffres = get_chiffres();

$articleCats = [];
foreach ($articles as $article) {
    $cat = $article['categorie'] ?? '';
    if ($cat !== '') {
        $articleCats[$cat] = true;
    }
}

$supportTypes = [];
foreach ($supports as $support) {
    $type = $support['type'] ?? '';
    if ($type !== '') {
        $supportTypes[$type] = true;
    }
}

$initials = static function (string $name): string {
    $parts = preg_split('/\s+/u', trim($name)) ?: [];
    $parts = array_values(array_filter($parts, static fn($part) => $part !== ''));
    if ($parts === []) {
        return 'GR';
    }
    $first = mb_strtoupper(mb_substr($parts[0], 0, 1));
    $last = count($parts) > 1 ? mb_strtoupper(mb_substr($parts[array_key_last($parts)], 0, 1)) : '';
    return $first . $last;
};

$readTime = static function (array $article): int {
    $text = trim(strip_tags(($article['contenu'] ?? '') . ' ' . ($article['extrait'] ?? '')));
    $words = preg_split('/\s+/u', $text, -1, PREG_SPLIT_NO_EMPTY) ?: [];
    return max(2, (int) ceil(count($words) / 180));
};
?>

<section class="hero">
  <div class="container hero-grid">
    <div>
      <p class="eyebrow">S'informer / Agir</p>
      <h1>Ressources</h1>
      <p class="lead">Guides, questions fréquentes, supports à télécharger et un glossaire clair pour parler des règles sans tabou, à la maison comme à l'école.</p>
    </div>
    <div class="media-frame">
      <img src="<?= e(asset('img/hero-ressources.jpg')) ?>" alt="Ressources éducatives Gouttes Rouges">
    </div>
  </div>
</section>

<section class="section section-insights" id="articles">
  <div class="container">
    <div class="insights-head">
      <div>
        <h2 class="section-title">Articles &amp; guides</h2>
        <p class="lead">Des contenus clairs pour s'informer et accompagner les filles, les familles et les relais.</p>
      </div>
      <div class="filter-pills" data-filter-group>
        <button type="button" class="is-active" data-filter="all">Tous</button>
        <?php foreach (array_keys($articleCats) as $cat): ?>
          <button type="button" data-filter="<?= e($cat) ?>"><?= e($cat) ?></button>
        <?php endforeach; ?>
      </div>
    </div>
    <div class="insights-grid">
      <?php foreach ($articles as $article): ?>
        <a class="insight-card" href="<?= e(url('article.php?slug=' . $article['slug'])) ?>" data-category="<?= e($article['categorie'] ?? '') ?>">
          <div class="insight-media">
            <img src="<?= e(asset($article['image'])) ?>" alt="">
            <span class="insight-badge"><?= e($article['categorie'] ?? 'Guide') ?></span>
          </div>
          <div class="insight-body">
            <h3><?= e($article['titre']) ?></h3>
            <p><?= e($article['extrait']) ?></p>
            <div class="insight-author">
              <span class="insight-avatar" aria-hidden="true"><?= e($initials($article['auteur'] ?? 'Gouttes Rouges')) ?></span>
              <div>
                <strong><?= e($article['auteur'] ?? 'Rédaction Gouttes Rouges') ?></strong>
                <span><?= e(format_date($article['date_publication'])) ?> · <?= (int) $readTime($article) ?> min</span>
              </div>
            </div>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section section-alt" id="faq">
  <div class="container">
    <div class="section-head">
      <h2 class="section-title">Foire aux questions</h2>
    </div>
    <div style="max-width:760px;margin:0 auto">
      <?php foreach ($faq as $item): ?>
        <div class="faq-item">
          <button type="button"><?= e($item['question']) ?> <span>+</span></button>
          <div class="answer"><?= e($item['reponse']) ?></div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section section-edu" id="supports">
  <div class="container">
    <div class="edu-head">
      <div>
        <h2 class="section-title">Supports éducatifs</h2>
        <p class="lead">Documents à consulter ou à télécharger pour animer un atelier ou accompagner une adolescente.</p>
      </div>
      <div class="edu-tabs" data-filter-group>
        <button type="button" class="is-active" data-filter="all">Tous</button>
        <?php foreach (array_keys($supportTypes) as $type): ?>
          <button type="button" data-filter="<?= e($type) ?>"><?= e($type) ?></button>
        <?php endforeach; ?>
      </div>
    </div>
    <div class="edu-grid">
      <?php foreach ($supports as $support): ?>
        <article class="edu-card" data-category="<?= e($support['type'] ?? '') ?>">
          <div class="edu-card-top">
            <div>
              <h3><?= e($support['titre']) ?></h3>
              <p class="edu-type"><?= e($support['type']) ?></p>
            </div>
          </div>
          <p class="edu-text"><?= e($support['description']) ?></p>
          <a class="edu-download" href="<?= e(asset($support['fichier'])) ?>" download title="Télécharger" aria-label="Télécharger <?= e($support['titre']) ?>">
            <?= icon_svg('download') ?>
          </a>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section section-alt" id="statistiques">
  <div class="container">
    <div class="section-head">
      <h2 class="section-title">Statistiques</h2>
      <p class="lead">Quelques indicateurs issus de nos actions de terrain. Ils sont actualisés par l'administration.</p>
    </div>
    <div class="grid-4">
      <?php foreach ($chiffres as $chiffre): ?>
        <article class="stat-card">
          <div class="icon-box"><?= icon_svg($chiffre['icone'] ?? 'star') ?></div>
          <strong><?= e($chiffre['valeur']) ?></strong>
          <span><?= e($chiffre['libelle']) ?></span>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section" id="glossaire">
  <div class="container">
    <div class="section-head">
      <h2 class="section-title">Glossaire</h2>
    </div>
    <dl class="glossary" style="max-width:760px;margin:0 auto">
      <?php foreach ($glossaire as $item): ?>
        <div>
          <dt><?= e($item['terme']) ?></dt>
          <dd><?= e($item['definition']) ?></dd>
        </div>
      <?php endforeach; ?>
    </dl>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
