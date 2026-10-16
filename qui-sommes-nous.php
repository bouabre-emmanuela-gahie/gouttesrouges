<?php
require_once __DIR__ . '/includes/icons.php';
$pageTitle = 'Qui sommes-nous ? — Gouttes Rouges';
$pageDescription = 'Histoire, mission, valeurs, équipe et partenaires de l\'association Gouttes Rouges.';
require __DIR__ . '/includes/header.php';
$equipe = get_equipe();
$partenaires = get_partenaires();
$valeurs = fallback_valeurs();
$chiffres = get_chiffres();
$temoignages = get_temoignages();

$missions = [
    ['titre' => 'Éduquer sans tabou', 'texte' => 'Des ateliers en milieu scolaire et communautaire pour comprendre le cycle, déconstruire les mythes et adopter les bons gestes d\'hygiène, avec des mots simples et justes.', 'image' => 'img/programme-1.jpg'],
    ['titre' => 'Équiper chaque fille', 'texte' => 'Des kits menstruels, des stocks d\'urgence dans les écoles et des dons en nature pour que plus aucune fille ne manque la classe faute de protection.', 'image' => 'img/programme-2.jpg'],
    ['titre' => 'Porter la voix des filles', 'texte' => 'Un plaidoyer auprès des établissements, des collectivités et des institutions pour faire reconnaître la santé menstruelle comme un droit.', 'image' => 'img/programme-3.jpg'],
    ['titre' => 'Bâtir un changement durable', 'texte' => 'Clubs, mentorat et relais communautaires formés pour que les jeunes filles deviennent elles-mêmes actrices du changement dans leur quartier.', 'image' => 'img/programme-4.jpg'],
];

$iconesValeurs = ['heart', 'users', 'book', 'check'];

$phases = [
    ['etape' => 'Court terme', 'titre' => 'Sensibiliser', 'texte' => 'Ateliers, causeries et campagnes pour briser le silence dans les écoles, les familles et les quartiers.', 'image' => 'img/campagne-1.jpg'],
    ['etape' => 'Moyen terme', 'titre' => 'Équiper', 'texte' => 'Distribution de kits, aménagement d\'espaces dignes et suivi des bénéficiaires pour lever les obstacles concrets.', 'image' => 'img/campagne-2.jpg'],
    ['etape' => 'Long terme', 'titre' => 'Pérenniser', 'texte' => 'Former des relais, accompagner les clubs et convaincre les institutions pour que le changement dure sans nous.', 'image' => 'img/campagne-3.jpg'],
];

$vision = [
    'Chaque fille a accès à une information fiable sur son corps',
    'Chaque fille dispose de protections sûres et suffisantes',
    'Chaque école offre un espace digne pour se changer',
    'Chaque communauté parle des règles sans honte',
];
?>

<section class="ab-hero">
  <img class="ab-hero-bg" src="<?= e(asset('img/hero-about.jpg')) ?>" alt="">
  <div class="ab-hero-glow" aria-hidden="true"></div>
  <div class="ab-hero-overlay" aria-hidden="true"></div>
  <div class="container ab-hero-inner">
    <div class="ab-hero-grid">
      <div class="ab-fade-load">
        <span class="ab-pill">Qui sommes-nous ?</span>
        <h1 class="ab-display">Briser le silence. Rendre la dignité.</h1>
        <p class="ab-hero-sub">Éducation, protections et plaidoyer pour la santé menstruelle en Côte d'Ivoire.</p>
      </div>
      <p class="ab-hero-quote ab-fade-load is-delayed">Aucune fille ne devrait manquer l'école parce qu'elle a ses règles.</p>
    </div>
  </div>
</section>

<section class="ab-story-top" id="presentation">
  <div class="container">
    <div class="ab-heading-left" data-reveal>
      <p class="ab-caps">Notre histoire</p>
      <p class="ab-extra">En Côte d'Ivoire, trop de filles manquent l'école, se taisent ou improvisent des protections dangereuses faute d'information et de matériel. Gouttes Rouges est née pour que les règles ne soient plus jamais un facteur d'exclusion.</p>
    </div>
  </div>
</section>

<section class="ab-story" id="histoire">
  <img class="ab-story-img is-desktop" src="<?= e(asset('img/histoire.jpg')) ?>" alt="Atelier communautaire Gouttes Rouges" data-reveal="left">
  <div class="container">
    <div class="ab-story-grid">
      <div data-reveal="left">
        <img class="ab-story-img is-mobile" src="<?= e(asset('img/histoire.jpg')) ?>" alt="">
      </div>
      <div class="ab-story-col" data-reveal="right">
        <p>Tout a commencé par quelques ateliers dans des établissements d'Abidjan. Le constat était partout le même : honte, absences répétées, chiffons et papier journal en guise de protection.</p>
        <p class="ab-large ab-red">Nous travaillons avec les écoles, les relais communautaires et nos partenaires pour que chaque fille vive ses règles en sécurité, informée et sans honte.</p>
        <p>Depuis, l'association a étendu son action aux villes de l'intérieur : campagnes nationales, distribution de kits, clubs scolaires et plaidoyer institutionnel.</p>
        <div>
          <h3 class="ab-h6">Ce qui nous anime</h3>
          <p>La conviction qu'une information claire et une protection digne changent une scolarité, une confiance en soi et, à terme, toute une communauté.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="ab-mission" id="mission">
  <div class="ab-mission-grid">
    <div class="ab-mission-left">
      <div class="ab-mission-inner">
        <p class="ab-caps">Notre mission</p>
        <h2 class="ab-h2 is-white">Quatre leviers pour changer les choses.</h2>
        <div class="ab-accordion" data-accordion>
          <?php foreach ($missions as $i => $mission): ?>
            <div class="ab-acc-item<?= $i === 0 ? ' is-active' : '' ?>">
              <button class="ab-acc-btn" type="button" aria-expanded="<?= $i === 0 ? 'true' : 'false' ?>" data-index="<?= $i ?>">
                <?= e($mission['titre']) ?>
              </button>
              <div class="ab-acc-panel">
                <div>
                  <p><?= e($mission['texte']) ?></p>
                  <img class="ab-acc-img-mobile" src="<?= e(asset($mission['image'])) ?>" alt="">
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
    <div class="ab-mission-right" aria-hidden="true">
      <?php foreach ($missions as $i => $mission): ?>
        <img class="ab-mission-img<?= $i === 0 ? ' is-active' : '' ?>" src="<?= e(asset($mission['image'])) ?>" alt="">
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="ab-section" id="valeurs">
  <div class="container ab-container-sm">
    <div class="ab-heading-center" data-reveal>
      <p class="ab-caps">Ce qui nous guide</p>
      <h2 class="ab-h2">Quatre valeurs. Un seul engagement.</h2>
    </div>
    <div class="ab-values" data-reveal>
      <?php foreach ($valeurs as $i => $valeur): ?>
        <article class="ab-value<?= $i === 0 ? ' is-rose' : ($i === 3 ? ' is-warm' : '') ?>">
          <div class="ab-value-icon"><?= icon_svg($iconesValeurs[$i] ?? 'star') ?></div>
          <div>
            <h3 class="ab-h6"><?= e($valeur['titre']) ?></h3>
            <p><?= e($valeur['texte']) ?></p>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="ab-phases-section">
  <div class="container ab-container-lg">
    <div class="ab-heading-center" data-reveal>
      <p class="ab-caps">Comment le changement opère</p>
      <h2 class="ab-h2">Trois étapes d'impact.</h2>
    </div>
    <div class="ab-phases" data-phases data-reveal>
      <?php foreach ($phases as $i => $phase): ?>
        <img class="ab-phase-bg<?= $i === 0 ? ' is-active' : '' ?>" src="<?= e(asset($phase['image'])) ?>" alt="">
      <?php endforeach; ?>
      <div class="ab-phase-shade" aria-hidden="true"></div>
      <div class="ab-phase-grid">
        <?php foreach ($phases as $i => $phase): ?>
          <div class="ab-phase<?= $i === 0 ? ' is-active' : '' ?>" tabindex="0" data-index="<?= $i ?>">
            <span class="ab-phase-num"><?= $i + 1 ?></span>
            <div class="ab-phase-body">
              <span class="ab-pill is-small"><?= e($phase['etape']) ?></span>
              <h3 class="ab-h5"><?= e($phase['titre']) ?></h3>
              <p><?= e($phase['texte']) ?></p>
            </div>
            <img class="ab-phase-img-mobile" src="<?= e(asset($phase['image'])) ?>" alt="">
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>

<section class="ab-testimonials">
  <div class="container ab-container-sm">
    <div class="ab-testi-grid">
      <div data-reveal="left">
        <h2 class="ab-h2">Chaque histoire mérite d'être entendue.</h2>
        <p class="ab-testi-text">Un accompagnement bienveillant aide les filles à reprendre confiance, à rester à l'école et à faire entendre leur voix.</p>
      </div>
      <div class="ab-slider" data-slider data-reveal="right">
        <svg class="ab-quote-icon" width="44" height="34" viewBox="0 0 44 34" aria-hidden="true"><path d="M0 34V20.4C0 8.9 6.3 2.1 17.6 0l1.9 4.6C13 6.4 9.9 10 9.4 15.6H18V34H0zm25.9 0V20.4C25.9 8.9 32.2 2.1 43.5 0l1.9 4.6c-6.5 1.8-9.6 5.4-10.1 11H44V34H25.9z" fill="currentColor"/></svg>
        <div class="ab-slider-mask">
          <div class="ab-slider-track">
            <?php foreach ($temoignages as $temoignage): ?>
              <figure class="ab-slide">
                <blockquote class="ab-extra"><?= e($temoignage['citation']) ?></blockquote>
                <figcaption class="ab-testi-person">
                  <img src="<?= e(asset($temoignage['photo'])) ?>" alt="">
                  <div>
                    <strong><?= e($temoignage['nom']) ?></strong>
                    <span><?= e($temoignage['role']) ?></span>
                  </div>
                </figcaption>
              </figure>
            <?php endforeach; ?>
          </div>
        </div>
        <div class="ab-slider-arrows">
          <button class="ab-arrow" type="button" data-prev aria-label="Témoignage précédent">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg>
          </button>
          <button class="ab-arrow" type="button" data-next aria-label="Témoignage suivant">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
          </button>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="ab-impact">
  <div class="container ab-container-sm">
    <div class="ab-heading-center" data-reveal>
      <p class="ab-caps is-white">Notre impact</p>
      <h2 class="ab-h2 is-white">Des chiffres qui racontent une histoire.</h2>
      <p class="ab-impact-text">Derrière chaque chiffre, une fille qui retourne en classe, une famille qui ose en parler, une école qui change ses pratiques.</p>
    </div>
    <div class="ab-impact-grid" data-reveal>
      <?php foreach (array_slice($chiffres, 0, 4) as $chiffre):
        $raw = preg_replace('/\D+/', '', $chiffre['valeur']);
        $suffix = str_replace($raw, '', $chiffre['valeur']);
      ?>
        <div class="ab-impact-item">
          <strong data-count="<?= e($raw) ?>" data-suffix="<?= e($suffix) ?>">0<?= e($suffix) ?></strong>
          <span><?= e($chiffre['libelle']) ?></span>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="ab-section ab-vision">
  <div class="container">
    <div class="ab-vision-grid">
      <div data-reveal="left">
        <p class="ab-caps">Notre vision</p>
        <h2 class="ab-h2">Un monde où les règles ne freinent plus aucun rêve.</h2>
        <p class="ab-vision-text">Une société où la santé menstruelle est comprise, respectée et prise en charge, pour que chaque fille et chaque femme puisse apprendre, travailler et s'épanouir librement.</p>
        <ul class="ab-checklist">
          <?php foreach ($vision as $point): ?>
            <li><span class="ab-check"><?= icon_svg('check') ?></span><?= e($point) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
      <div data-reveal="right">
        <img class="ab-vision-img" src="<?= e(asset('img/programme-5.jpg')) ?>" alt="Jeunes filles accompagnées par Gouttes Rouges">
      </div>
    </div>
  </div>
</section>

<section class="ab-people" id="equipe">
  <div class="container">
    <div class="ab-people-head" data-reveal>
      <div>
        <p class="ab-caps">L'équipe</p>
        <h2 class="ab-h2">Portée par des personnes engagées.</h2>
      </div>
      <p>Santé, éducation, plaidoyer, terrain : notre équipe réunit des compétences complémentaires au service d'une même cause. <a href="<?= e(url('nous-soutenir.php')) ?>#benevolat">Rejoignez-nous !</a></p>
    </div>
    <div class="ab-people-grid" data-reveal>
      <?php foreach ($equipe as $membre): ?>
        <article class="ab-person">
          <img src="<?= e(asset($membre['photo'])) ?>" alt="<?= e($membre['nom']) ?>">
          <div>
            <h3 class="ab-h6"><?= e($membre['nom']) ?></h3>
            <span><?= e($membre['fonction']) ?></span>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="ab-partners" id="partenaires">
  <div class="container">
    <p class="ab-caps">Ils soutiennent la cause</p>
    <div class="partners">
      <?php foreach ($partenaires as $partenaire): ?>
        <div class="partner-slot"><?= e($partenaire['nom']) ?></div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="ab-cta">
  <img class="ab-cta-bg" src="<?= e(asset('img/hero-soutenir.jpg')) ?>" alt="">
  <div class="ab-cta-overlay" aria-hidden="true"></div>
  <div class="container ab-cta-inner" data-reveal>
    <h2 class="ab-h2 is-white">Marchons ensemble pour la dignité menstruelle</h2>
    <p>Votre soutien se transforme en kits, en ateliers et en filles qui restent à l'école.</p>
    <div class="ab-cta-actions">
      <a class="btn ab-btn-red" href="<?= e(url('nous-soutenir.php')) ?>#don">Faire un don</a>
      <a class="btn btn-ghost" href="<?= e(url('nous-soutenir.php')) ?>#partenariat">Devenir partenaire</a>
    </div>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
