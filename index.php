<?php
require_once __DIR__ . '/includes/icons.php';
$pageTitle = 'Accueil — Gouttes Rouges';
$pageDescription = 'Gouttes Rouges sensibilise à la précarité menstruelle, agit en Côte d\'Ivoire et invite chacun à s\'engager.';
require __DIR__ . '/includes/header.php';

$articles = get_articles(3);
$chiffres = get_chiffres();
$domaines = array_slice(get_domaines(), 0, 4);
$slides = [
    [
        'image' => 'img/hero-accueil.jpg',
        'eyebrow' => 'Bienvenue !',
        'title' => 'Ensemble, construisons un avenir meilleur.',
        'text' => 'Gouttes Rouges lutte contre la précarité menstruelle, défend les droits des filles et des femmes et agit pour l\'éducation, la dignité et l\'autonomisation, à Abidjan comme dans les villes de l\'intérieur.',
    ],
    [
        'image' => 'img/hero-actions.jpg',
        'eyebrow' => 'Bienvenue !',
        'title' => 'La dignité menstruelle est un droit, pas un luxe.',
        'text' => 'Nous éduquons, distribuons des kits et ouvrons la parole pour que plus aucune fille ne manque l\'école à cause de ses règles.',
    ],
    [
        'image' => 'img/hero-soutenir.jpg',
        'eyebrow' => 'Bienvenue !',
        'title' => 'Agir ensemble, partout en Côte d\'Ivoire.',
        'text' => 'Clubs, campagnes et plaidoyer : chaque geste rapproche une adolescente d\'une vie menstruelle libre, informée et digne.',
    ],
];
?>

<section class="home-banner hero-slider" aria-label="Bannière">
  <?php foreach ($slides as $i => $slide): ?>
    <div class="slide<?= $i === 0 ? ' is-active' : '' ?>">
      <div class="container home-banner-grid">
        <div class="home-banner-copy">
          <p class="eyebrow"><?= e($slide['eyebrow']) ?></p>
          <h1><?= e($slide['title']) ?></h1>
          <p class="lead"><?= e($slide['text']) ?></p>
          <div class="hero-actions">
            <a class="btn btn-dark" href="<?= e(url('nos-actions.php')) ?>">Découvrir nos actions</a>
            <a class="btn btn-light" href="<?= e(url('qui-sommes-nous.php')) ?>">En savoir plus</a>
          </div>
        </div>
        <div class="home-banner-media">
          <img src="<?= e(asset($slide['image'])) ?>" alt="">
        </div>
      </div>
    </div>
  <?php endforeach; ?>
  <div class="slider-dots home-banner-dots"></div>
</section>

<section class="section" id="actions-bref">
  <div class="container">
    <div class="section-row">
      <h2 class="section-title">Nos actions</h2>
      <a class="link-more" href="<?= e(url('nos-actions.php')) ?>">Voir toutes nos actions &gt;</a>
    </div>
    <div class="home-action-grid">
      <?php foreach ($domaines as $domaine): ?>
        <article class="home-action-card">
          <img src="<?= e(asset($domaine['image'] ?? 'img/hero-actions.jpg')) ?>" alt="">
          <div class="body">
            <h3><?= e($domaine['titre']) ?></h3>
            <p><?= e($domaine['texte']) ?></p>
            <a class="link-more" href="<?= e(url('nos-actions.php')) ?>">En savoir plus &gt;</a>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section section-alt" id="chiffres">
  <div class="container impact-split">
    <div>
      <p class="eyebrow">Notre impact</p>
      <h2 class="section-title">Des chiffres qui racontent notre engagement</h2>
      <p class="lead">Des indicateurs concrets, issus de nos actions de terrain en Côte d'Ivoire.</p>
    </div>
    <div class="impact-grid">
      <?php foreach ($chiffres as $chiffre):
        $raw = preg_replace('/\D+/', '', $chiffre['valeur']);
        $suffix = str_replace($raw, '', $chiffre['valeur']);
      ?>
        <article>
          <strong data-count="<?= e($raw) ?>" data-suffix="<?= e($suffix) ?>">0<?= e($suffix) ?></strong>
          <span><?= e($chiffre['libelle']) ?></span>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section" id="a-la-une">
  <div class="container">
    <div class="section-row">
      <h2 class="section-title">Actualités &amp; événements</h2>
      <a class="link-more" href="<?= e(url('ressources.php')) ?>#articles">Voir toutes les actualités &gt;</a>
    </div>
    <div class="news-grid">
      <?php foreach ($articles as $article): ?>
        <article class="article-card">
          <img src="<?= e(asset($article['image'])) ?>" alt="">
          <div class="body">
            <div class="tag">Actualité</div>
            <h3><?= e($article['titre']) ?></h3>
            <p><?= e($article['extrait']) ?></p>
            <a class="link-more" href="<?= e(url('article.php?slug=' . $article['slug'])) ?>">Lire la suite &gt;</a>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section section-alt" id="ressources-utiles">
  <div class="container">
    <div class="section-row">
      <h2 class="section-title">Ressources utiles</h2>
      <a class="link-more" href="<?= e(url('ressources.php')) ?>">Voir toutes les ressources &gt;</a>
    </div>
    <div class="resource-lite">
      <a href="<?= e(url('ressources.php')) ?>#articles">
        <div class="icon-box"><?= icon_svg('book') ?></div>
        <h3>Articles &amp; guides</h3>
        <p>Des contenus clairs pour s'informer et accompagner.</p>
        <span class="link-more">Consulter &gt;</span>
      </a>
      <a href="<?= e(url('ressources.php')) ?>#faq">
        <div class="icon-box"><?= icon_svg('star') ?></div>
        <h3>Foire aux questions</h3>
        <p>Les réponses essentielles sur la précarité menstruelle.</p>
        <span class="link-more">Consulter &gt;</span>
      </a>
      <a href="<?= e(url('ressources.php')) ?>#supports">
        <div class="icon-box"><?= icon_svg('download') ?></div>
        <h3>Supports éducatifs</h3>
        <p>Fiches et affiches à télécharger pour les ateliers.</p>
        <span class="link-more">Consulter &gt;</span>
      </a>
      <a href="<?= e(url('ressources.php')) ?>#statistiques">
        <div class="icon-box"><?= icon_svg('megaphone') ?></div>
        <h3>Statistiques</h3>
        <p>Les indicateurs d'impact de nos actions de terrain.</p>
        <span class="link-more">Consulter &gt;</span>
      </a>
    </div>
  </div>
</section>

<section class="section">
  <div class="container support-cta">
    <div class="support-cta-photo">
      <img src="<?= e(asset('img/hero-soutenir.jpg')) ?>" alt="Soutenir Gouttes Rouges">
    </div>
    <div>
      <p class="eyebrow">Nous soutenir</p>
      <h2 class="section-title">Votre soutien fait la différence</h2>
      <p class="lead">Chaque don permet d'acheter des protections, d'organiser des ateliers et d'accompagner les filles là où le besoin est le plus urgent.</p>
      <a class="btn btn-dark" href="<?= e(url('nous-soutenir.php')) ?>#don">Faire un don</a>
    </div>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
