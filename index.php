<?php
require_once __DIR__ . '/includes/icons.php';
$pageTitle = 'Accueil — Gouttes Rouges';
$pageDescription = 'Gouttes Rouges sensibilise à la précarité menstruelle, agit en Côte d\'Ivoire et invite chacun à s\'engager.';
require __DIR__ . '/includes/header.php';

$articles = get_articles(3);
$chiffres = get_chiffres();
$programmes = array_slice(get_programmes(), 0, 3);
$campagnes = get_campagnes();
$slides = [
    [
        'image' => 'img/hero-accueil.jpg',
        'label' => 'Bienvenue chez Gouttes Rouges',
        'title' => 'Ensemble, construisons un avenir meilleur.',
        'text' => 'Contre la précarité menstruelle, pour l\'éducation et la dignité des filles et des femmes.',
    ],
    [
        'image' => 'img/hero-actions.jpg',
        'label' => 'Un droit, pas un luxe',
        'title' => 'La dignité menstruelle pour toutes.',
        'text' => 'Nous éduquons, distribuons des kits et ouvrons la parole pour qu\'aucune fille ne manque l\'école.',
    ],
    [
        'image' => 'img/hero-soutenir.jpg',
        'label' => 'Partout en Côte d\'Ivoire',
        'title' => 'Agir ensemble, d\'Abidjan à l\'intérieur.',
        'text' => 'Clubs, campagnes et plaidoyer pour une vie menstruelle libre, informée et digne.',
    ],
];
$etapes = [
    ['titre' => 'Votre don', 'texte' => 'Votre contribution finance des protections, des ateliers et le suivi des bénéficiaires.'],
    ['titre' => 'Notre action', 'texte' => 'Nos équipes et nos relais distribuent les kits et animent les ateliers dans les écoles et les quartiers.'],
    ['titre' => 'Leur dignité', 'texte' => 'Les filles restent en classe, osent en parler et vivent leurs règles sans honte.'],
];
$dons = [
    ['montant' => '5000', 'texte' => 'Contribue à un kit menstruel pour une fille'],
    ['montant' => '15000', 'texte' => 'Soutient un atelier d\'éducation en classe'],
    ['montant' => '25000', 'texte' => 'Aide à équiper un club scolaire'],
];
$premierChiffre = $chiffres[0] ?? ['valeur' => '5000+', 'libelle' => 'Filles sensibilisées'];
$premierRaw = preg_replace('/\D+/', '', $premierChiffre['valeur']);
$premierSuffix = str_replace($premierRaw, '', $premierChiffre['valeur']);
?>

<section class="hm-hero hero-slider" aria-label="Bannière">
  <?php foreach ($slides as $i => $slide): ?>
    <div class="slide hm-slide<?= $i === 0 ? ' is-active' : '' ?>">
      <img class="hm-slide-bg" src="<?= e(asset($slide['image'])) ?>" alt="">
    </div>
  <?php endforeach; ?>
  <div class="ab-hero-glow" aria-hidden="true"></div>
  <div class="hm-hero-overlay" aria-hidden="true"></div>
  <div class="container hm-hero-inner">
    <div class="hm-hero-grid">
      <div class="hm-hero-copy">
        <?php foreach ($slides as $i => $slide): ?>
          <div class="hm-slide-text<?= $i === 0 ? ' is-active' : '' ?>" data-slide-text="<?= $i ?>">
            <span class="ab-pill"><?= e($slide['label']) ?></span>
            <?php if ($i === 0): ?>
              <h1 class="ab-display"><?= e($slide['title']) ?></h1>
            <?php else: ?>
              <p class="ab-display"><?= e($slide['title']) ?></p>
            <?php endif; ?>
            <p class="ab-hero-sub"><?= e($slide['text']) ?></p>
          </div>
        <?php endforeach; ?>
        <div class="slider-dots hm-dots"></div>
      </div>
      <div class="hm-hero-side ab-fade-load is-delayed">
        <div class="hm-glass"><span></span>Kits, ateliers et plaidoyer</div>
        <div class="hm-glass"><span></span>Abidjan et villes de l'intérieur</div>
        <div class="hm-hero-card">
          <div class="hm-card-top">
            <strong>Gouttes Rouges</strong>
            <span><i></i><?= date('Y') ?></span>
          </div>
          <div>
            <div class="hm-card-icon"><?= icon_svg('heart') ?></div>
            <h2 class="ab-h6">Soyez la raison pour laquelle une fille reste à l'école.</h2>
            <p>Un don, c'est des protections, une information juste et de la confiance.</p>
            <a class="hm-btn" href="<?= e(url('nous-soutenir.php')) ?>#don">Faire un don</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="ab-section hm-measured">
  <div class="container ab-container-sm">
    <div class="ab-heading-center hm-measured-head" data-reveal>
      <p class="ab-caps">Un impact mesuré. Un changement durable.</p>
      <h2 class="ab-extra">Gouttes Rouges agit au plus près des écoles et des quartiers pour combler le manque d'information, de protections et de dignité autour des règles.</h2>
    </div>
    <div class="hm-stats" data-reveal>
      <?php foreach (array_slice($chiffres, 0, 3) as $chiffre):
        $raw = preg_replace('/\D+/', '', $chiffre['valeur']);
        $suffix = str_replace($raw, '', $chiffre['valeur']);
      ?>
        <div class="hm-stat">
          <strong data-count="<?= e($raw) ?>" data-suffix="<?= e($suffix) ?>">0<?= e($suffix) ?></strong>
          <span><?= e($chiffre['libelle']) ?></span>
          <i class="hm-stat-line"></i>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="hm-story">
  <div class="container ab-container-lg">
    <div class="hm-story-images">
      <div class="hm-story-img" data-reveal="left">
        <img src="<?= e(asset('img/histoire.jpg')) ?>" alt="Mains unies peintes en rouge">
        <svg class="hm-story-icon is-bottom" viewBox="0 0 28 36" aria-hidden="true"><path d="M14 1.5C14 1.5 2.5 14.2 2.5 22.2a11.5 11.5 0 1 0 23 0C25.5 14.2 14 1.5 14 1.5z" fill="#fff"/></svg>
      </div>
      <div class="hm-story-img" data-reveal="right">
        <img src="<?= e(asset('img/programme-1.jpg')) ?>" alt="Atelier avec des jeunes filles">
        <span class="hm-story-icon is-top"><?= icon_svg('heart') ?></span>
      </div>
    </div>
  </div>
  <div class="container ab-container-sm">
    <div class="hm-story-grid">
      <div data-reveal="left">
        <p class="ab-caps">Notre histoire</p>
        <h2 class="ab-h2">Aux côtés des filles face à la précarité menstruelle</h2>
      </div>
      <div data-reveal="right">
        <p>La précarité menstruelle ne touche pas seulement le quotidien : elle touche la scolarité, la santé et la confiance en soi de milliers de filles.</p>
        <p>Nous intervenons là où le besoin est le plus fort, puis nous restons : clubs scolaires, relais communautaires et plaidoyer pour que le changement dure.</p>
        <a class="hm-btn is-dark" href="<?= e(url('qui-sommes-nous.php')) ?>">Qui sommes-nous ?</a>
      </div>
    </div>
  </div>
</section>

<section class="hm-programs">
  <div class="container">
    <div class="ab-heading-center" data-reveal>
      <p class="ab-caps is-white">Nos actions</p>
      <h2 class="ab-h2 is-white">Des programmes pensés pour durer.</h2>
    </div>
    <div class="hm-program-grid" data-reveal>
      <?php foreach ($programmes as $programme): ?>
        <a class="hm-program" href="<?= e(url('nos-actions.php')) ?>#<?= e($programme['ancre']) ?>">
          <div class="hm-program-img"><img src="<?= e(asset($programme['image'])) ?>" alt=""></div>
          <div class="hm-program-box">
            <h3 class="ab-h5"><?= e($programme['titre']) ?></h3>
            <p><?= e($programme['texte']) ?></p>
            <i class="hm-program-divider"></i>
            <span class="hm-program-more">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M7 17 17 7M8 7h9v9"/></svg>
              Découvrir le programme
            </span>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
    <p class="hm-programs-more"><a class="hm-btn is-outline" href="<?= e(url('nos-actions.php')) ?>">Voir toutes nos actions</a></p>
  </div>
</section>

<section class="ab-section hm-difference">
  <div class="container">
    <div class="hm-diff-head" data-reveal>
      <p class="ab-caps">Simple. Transparent.</p>
      <h2 class="ab-h2">Faites la différence</h2>
      <p>Votre contribution aide les filles à s'informer, à se protéger et à rester à l'école. Voici comment votre soutien se transforme en action.</p>
      <a class="hm-btn is-dark" href="<?= e(url('contact.php')) ?>">Nous contacter</a>
    </div>
    <div class="hm-diff-steps" data-reveal>
      <svg class="hm-diff-wave" viewBox="0 0 1200 420" preserveAspectRatio="none" aria-hidden="true"><path d="M0 400 C 220 400, 260 280, 420 270 S 700 200, 800 140 S 1050 40, 1200 20" fill="none" stroke="currentColor" stroke-width="3"/></svg>
      <?php foreach ($etapes as $i => $etape): ?>
        <div class="hm-diff-step">
          <span class="hm-circle"><i></i></span>
          <div class="hm-diff-box">
            <h3 class="ab-h5"><?= e($etape['titre']) ?></h3>
            <p><?= e($etape['texte']) ?></p>
            <span class="hm-diff-num"><?= $i + 1 ?></span>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="ab-section hm-stories">
  <div class="container ab-container-sm">
    <div class="ab-heading-center" data-reveal>
      <p class="ab-caps">Nos campagnes</p>
      <h2 class="ab-h2">Les histoires derrière l'impact</h2>
      <p class="hm-muted">Des campagnes de terrain qui ont ouvert la parole et changé le quotidien de milliers de filles.</p>
    </div>
  </div>
  <div class="container" data-reveal>
    <div class="hm-stories-track" data-carousel>
      <?php foreach ($campagnes as $campagne): ?>
        <a class="hm-story-card" href="<?= e(url('campagne.php?slug=' . $campagne['slug'])) ?>">
          <img src="<?= e(asset($campagne['image'])) ?>" alt="">
          <span class="hm-story-arrow"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M7 17 17 7M8 7h9v9"/></svg></span>
          <span class="hm-story-shade" aria-hidden="true"></span>
          <div class="hm-story-content">
            <span class="ab-pill is-small"><?= e(format_date($campagne['date_debut'])) ?></span>
            <h3 class="ab-h5"><?= e($campagne['titre']) ?></h3>
            <p><?= e(excerpt($campagne['description'], 110)) ?></p>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
    <div class="ab-slider-arrows hm-stories-arrows">
      <button class="ab-arrow" type="button" data-carousel-prev aria-label="Campagne précédente">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg>
      </button>
      <button class="ab-arrow" type="button" data-carousel-next aria-label="Campagne suivante">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
      </button>
    </div>
  </div>
</section>

<section class="hm-children">
  <div class="container ab-container-sm" data-reveal>
    <h2 class="hm-children-title">
      <span class="hm-children-count" data-count="<?= e($premierRaw) ?>" data-suffix="<?= e($premierSuffix) ?>">0<?= e($premierSuffix) ?></span>
      filles
    </h2>
    <p>ont déjà été sensibilisées, équipées ou accompagnées grâce aux programmes de Gouttes Rouges.</p>
    <a class="hm-btn" href="<?= e(url('nous-soutenir.php')) ?>#benevolat">Rejoindre la communauté</a>
  </div>
</section>

<section class="ab-impact hm-give">
  <div class="container ab-container-sm">
    <div class="ab-heading-center" data-reveal>
      <p class="ab-caps is-white">Un impact durable</p>
      <h2 class="ab-h2 is-white">Transformez votre générosité en changement durable</h2>
      <p class="ab-impact-text">Chaque montant compte : il se traduit en protections, en ateliers et en filles qui restent en classe.</p>
    </div>
    <div class="hm-give-grid" data-reveal>
      <?php foreach ($dons as $i => $don): ?>
        <div class="hm-give-box<?= $i === 1 ? ' is-active' : '' ?>">
          <strong><span data-count="<?= e($don['montant']) ?>">0</span> <small>XOF</small></strong>
          <span><?= e($don['texte']) ?></span>
        </div>
      <?php endforeach; ?>
    </div>
    <div class="ab-cta-actions" data-reveal>
      <a class="btn ab-btn-red" href="<?= e(url('nous-soutenir.php')) ?>#don">Faire un don</a>
      <a class="btn btn-ghost hm-pill-btn" href="<?= e(url('nos-actions.php')) ?>">Voir nos actions</a>
    </div>
  </div>
</section>

<section class="ab-section hm-future">
  <div class="container">
    <div class="hm-future-grid">
      <div class="hm-future-left" data-reveal="left">
        <img class="hm-future-img" src="<?= e(asset('img/programme-4.jpg')) ?>" alt="Jeune fille accompagnée par Gouttes Rouges">
        <img class="hm-future-circle" src="<?= e(asset('img/programme-5.jpg')) ?>" alt="">
      </div>
      <div data-reveal="right">
        <p class="ab-caps">Participez à leur avenir</p>
        <h2 class="ab-h2">Chaque fille mérite un espace sûr pour grandir</h2>
        <p class="hm-muted">Gouttes Rouges s'appuie sur des écoles, des associations et des bénévoles pour créer des réseaux d'entraide durables. Rejoignez-les : votre temps et vos compétences comptent.</p>
        <a class="hm-btn is-dark" href="<?= e(url('nous-soutenir.php')) ?>#benevolat">Devenir bénévole</a>
      </div>
    </div>
  </div>
</section>

<section class="hm-blog">
  <div class="container">
    <div class="ab-heading-center" data-reveal>
      <p class="ab-caps">Sur le terrain</p>
      <h2 class="ab-h2">Actualités &amp; guides</h2>
    </div>
    <div class="hm-blog-grid" data-reveal>
      <?php foreach ($articles as $article): ?>
        <a class="hm-post" href="<?= e(url('article.php?slug=' . $article['slug'])) ?>">
          <div class="hm-post-top">
            <img src="<?= e(asset($article['image'])) ?>" alt="">
            <span class="hm-post-cat"><?= e($article['categorie'] ?? 'Actualité') ?></span>
          </div>
          <h3 class="ab-h6"><?= e($article['titre']) ?></h3>
          <span class="hm-post-date"><?= e(format_date($article['date_publication'])) ?></span>
        </a>
      <?php endforeach; ?>
    </div>
    <p class="hm-programs-more"><a class="hm-btn is-dark" href="<?= e(url('ressources.php')) ?>">Toutes les ressources</a></p>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
