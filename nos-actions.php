<?php
require_once __DIR__ . '/includes/icons.php';
$pageTitle = 'Nos actions — Gouttes Rouges';
$pageDescription = 'Éducation menstruelle, lutte contre la précarité, plaidoyer, recherche et leadership des jeunes filles.';
require __DIR__ . '/includes/header.php';

$domaines = get_domaines();
$programmes = get_programmes();
$campagnes = get_campagnes(3);
$chiffres = get_chiffres();
$articles = get_articles(3);
$ancres = ['education', 'precarite', 'plaidoyer', 'recherche', 'leadership', 'communaute'];
?>

<section class="hero">
  <div class="container hero-grid">
    <div>
      <p class="eyebrow">Gouttes Rouges / Terrain</p>
      <h1>Nos Actions</h1>
      <p class="lead">Sur le terrain, nous éduquons, distribuons, plaidons et formons. Chaque programme vise un impact concret : moins de tabous, plus de protections, plus de filles qui restent à l'école et prennent la parole.</p>
    </div>
    <div class="media-frame">
      <img src="<?= e(asset('img/hero-actions.jpg')) ?>" alt="Action de sensibilisation Gouttes Rouges">
    </div>
  </div>
</section>

<section class="section section-alt" id="domaines">
  <div class="container">
    <div class="section-head">
      <p class="eyebrow">Nos domaines</p>
      <h2 class="section-title">Nos domaines d'intervention</h2>
      <p class="lead">Six leviers concrets pour que les règles cessent d'être un obstacle à l'école, à la santé et aux rêves.</p>
    </div>
    <div class="domain-service-grid">
      <?php foreach ($domaines as $i => $domaine): ?>
        <article class="domain-service-card<?= $i === 1 ? ' is-featured' : '' ?>" id="<?= e($ancres[$i] ?? 'domaine-' . $i) ?>">
          <div class="head">
            <h3><?= e($domaine['titre']) ?></h3>
            <p><?= e($domaine['texte']) ?></p>
          </div>
          <div class="visual">
            <img src="<?= e(asset($domaine['image'] ?? 'img/hero-actions.jpg')) ?>" alt="">
            <span class="icon-chip" aria-hidden="true"><?= icon_svg('check') ?></span>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section" id="programmes">
  <div class="container programs-choose">
    <div class="programs-choose-left">
      <p class="eyebrow">Nos programmes</p>
      <h2 class="section-title">Nos programmes à fort impact</h2>
      <div class="programs-photo">
        <img src="<?= e(asset($programmes[0]['image'] ?? 'img/programme-1.jpg')) ?>" alt="<?= e($programmes[0]['titre'] ?? '') ?>">
      </div>
    </div>
    <div class="program-list">
      <?php foreach ($programmes as $programme): ?>
        <article class="program-item" id="<?= e($programme['ancre']) ?>">
          <div class="check"><?= icon_svg('check') ?></div>
          <div>
            <h3><?= e($programme['titre']) ?></h3>
            <p><?= e($programme['texte']) ?></p>
            <a class="link-more" href="<?= e(url('nous-soutenir.php')) ?>">En savoir plus &gt;</a>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section section-alt" id="campagnes">
  <div class="container">
    <div class="section-head">
      <p class="eyebrow">Campagnes</p>
      <h2 class="section-title">Nos campagnes de sensibilisation</h2>
      <p class="lead">Des prises de parole publiques pour briser le silence, informer et rassembler.</p>
    </div>
    <div class="campaign-hugo">
      <?php foreach ($campagnes as $i => $campagne): ?>
        <a class="campaign-hugo-card<?= $i === 0 ? ' is-main' : '' ?>" href="<?= e(url('campagne.php?slug=' . $campagne['slug'])) ?>">
          <img src="<?= e(asset($campagne['image'])) ?>" alt="">
          <div class="overlay">
            <h3><?= e($campagne['titre']) ?></h3>
            <?php if ($i === 0): ?>
              <p><?= e($campagne['description']) ?></p>
            <?php endif; ?>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section stat-band" id="impact">
  <div class="container">
    <div class="section-head">
      <h2 class="section-title">Notre impact en chiffres</h2>
    </div>
    <div class="grid-4">
      <?php foreach ($chiffres as $chiffre):
        $raw = preg_replace('/\D+/', '', $chiffre['valeur']);
        $suffix = str_replace($raw, '', $chiffre['valeur']);
      ?>
        <article class="stat-card">
          <div class="icon-box"><?= icon_svg($chiffre['icone'] ?? 'star') ?></div>
          <strong data-count="<?= e($raw) ?>" data-suffix="<?= e($suffix) ?>">0<?= e($suffix) ?></strong>
          <span><?= e($chiffre['libelle']) ?></span>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section section-alt" id="actualites">
  <div class="container">
    <div class="section-head">
      <h2 class="section-title">Actualités &amp; événements</h2>
      <p class="lead">Les dernières actions liées à nos programmes.</p>
    </div>
    <div class="news-grid">
      <?php foreach ($articles as $article): ?>
        <article class="article-card">
          <img src="<?= e(asset($article['image'])) ?>" alt="">
          <div class="body">
            <div class="meta"><?= e(format_date($article['date_publication'])) ?></div>
            <h3><?= e($article['titre']) ?></h3>
            <a class="link-more" href="<?= e(url('article.php?slug=' . $article['slug'])) ?>">Lire la suite &gt;</a>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="cta-band">
  <div class="container">
    <h2>Participez à nos prochaines actions</h2>
    <p>Rejoignez les ateliers, les distributions et les campagnes. Votre présence change le quotidien des filles que nous accompagnons.</p>
    <div class="cta-actions" style="justify-content:center">
      <a class="btn btn-ghost" href="<?= e(url('nous-soutenir.php')) ?>#benevolat">Nous rejoindre</a>
      <a class="btn btn-ghost" href="<?= e(url('contact.php')) ?>">Nous contacter</a>
    </div>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
