<?php
require_once __DIR__ . '/includes/icons.php';
$pageTitle = 'Qui sommes-nous ? — Gouttes Rouges';
$pageDescription = 'Histoire, mission, valeurs, équipe et partenaires de l\'association Gouttes Rouges.';
require __DIR__ . '/includes/header.php';
$equipe = get_equipe();
$partenaires = get_partenaires();
$valeurs = fallback_valeurs();
$chiffres = get_chiffres();
?>

<section class="section" id="presentation">
  <div class="container split-about">
    <div class="split-photo">
      <img src="<?= e(asset('img/hero-about.jpg')) ?>" alt="L'équipe Gouttes Rouges">
    </div>
    <div>
      <p class="eyebrow">Association / Côte d'Ivoire</p>
      <h1>Qui sommes-nous ?</h1>
      <p class="lead">Gouttes Rouges est une organisation engagée pour la santé menstruelle et reproductive. Nous agissons à Abidjan et dans les villes de l'intérieur contre la précarité menstruelle, pour l'éducation, le plaidoyer et l'autonomisation des jeunes filles.</p>
      <div class="hero-actions">
        <a class="btn btn-dark" href="<?= e(url('nos-actions.php')) ?>">Découvrir nos actions</a>
        <a class="btn btn-light" href="<?= e(url('nous-soutenir.php')) ?>">Nous soutenir</a>
      </div>
      <div class="split-stats">
        <?php foreach (array_slice($chiffres, 0, 3) as $chiffre):
          $raw = preg_replace('/\D+/', '', $chiffre['valeur']);
          $suffix = str_replace($raw, '', $chiffre['valeur']);
        ?>
          <div>
            <strong data-count="<?= e($raw) ?>" data-suffix="<?= e($suffix) ?>">0<?= e($suffix) ?></strong>
            <span><?= e($chiffre['libelle']) ?></span>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>

<section class="section section-alt" id="histoire">
  <div class="container split-about is-reverse">
    <div>
      <h2>Notre histoire</h2>
      <p class="lead">Gouttes Rouges est née d'un constat simple et violent : trop de filles manquent l'école, se taisent ou improvisent des protections dangereuses faute d'accès à l'information et au matériel.</p>
      <p>À partir d'ateliers menés dans quelques établissements d'Abidjan, l'association a étendu son action aux campagnes nationales, aux dons de kits et au plaidoyer institutionnel. Aujourd'hui, nous travaillons avec des écoles, des relais communautaires et des partenaires pour que les règles ne soient plus un facteur d'exclusion.</p>
      <div class="hero-actions">
        <a class="btn btn-dark" href="#equipe">Notre équipe</a>
        <a class="btn btn-light" href="#partenaires">Les partenaires</a>
      </div>
    </div>
    <div class="split-photo">
      <img src="<?= e(asset('img/histoire.jpg')) ?>" alt="Atelier communautaire">
    </div>
  </div>
</section>

<section class="section" id="mission">
  <div class="container">
    <div class="section-head">
      <h2 class="section-title">Notre mission</h2>
      <p class="lead">Garantir à chaque fille et chaque femme un accès digne à l'information, aux protections et à la parole, pour que la santé menstruelle cesse d'être un tabou ou un luxe.</p>
    </div>
  </div>
</section>

<section class="section section-alt" id="valeurs">
  <div class="container">
    <div class="section-head">
      <h2 class="section-title">Nos valeurs</h2>
    </div>
    <div class="values-core">
      <div class="values-col">
        <?php foreach (array_slice($valeurs, 0, 2) as $valeur): ?>
          <article class="value-box">
            <div class="icon-box"><?= icon_svg('star') ?></div>
            <h3><?= e($valeur['titre']) ?></h3>
            <p><?= e($valeur['texte']) ?></p>
          </article>
        <?php endforeach; ?>
      </div>
      <div class="values-center">
        <img src="<?= e(asset('img/team-1.jpg')) ?>" alt="Portrait — valeurs Gouttes Rouges">
      </div>
      <div class="values-col">
        <?php foreach (array_slice($valeurs, 2, 2) as $valeur): ?>
          <article class="value-box">
            <div class="icon-box"><?= icon_svg('heart') ?></div>
            <h3><?= e($valeur['titre']) ?></h3>
            <p><?= e($valeur['texte']) ?></p>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>

<section class="section" id="equipe">
  <div class="container">
    <div class="section-head">
      <h2 class="section-title">Notre équipe</h2>
    </div>
    <div class="team-grid">
      <?php foreach ($equipe as $membre): ?>
        <article class="team-card">
          <img src="<?= e(asset($membre['photo'])) ?>" alt="<?= e($membre['nom']) ?>">
          <h3><?= e($membre['nom']) ?></h3>
          <div class="role"><?= e($membre['fonction']) ?></div>
          <p><?= e($membre['bio']) ?></p>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section section-alt" id="partenaires">
  <div class="container">
    <p class="kicker">Ils soutiennent la cause</p>
    <div class="partners">
      <?php foreach ($partenaires as $partenaire): ?>
        <div class="partner-slot"><?= e($partenaire['nom']) ?></div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="cta-band">
  <div class="container">
    <h2>Marchons ensemble</h2>
    <p>Vous représentez une école, une entreprise ou une collectivité ? Devenons partenaires.</p>
    <a class="btn btn-ghost" href="<?= e(url('nous-soutenir.php')) ?>#partenariat">Devenir partenaire</a>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
