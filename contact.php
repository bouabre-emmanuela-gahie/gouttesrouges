<?php
$pageTitle = 'Contact — Gouttes Rouges';
$pageDescription = 'Écrire à Gouttes Rouges, consulter nos coordonnées et nous trouver à Abidjan.';
require __DIR__ . '/includes/header.php';
?>

<section class="hero">
  <div class="container hero-grid">
    <div>
      <h1>Contact</h1>
      <p class="lead">Une question, une demande d'intervention ou un partenariat ? Écrivez-nous. Nous répondons aux messages reçus via ce formulaire.</p>
    </div>
    <div class="media-frame">
      <img src="<?= e(asset('img/hero-contact.jpg')) ?>" alt="Accueil de l'association">
    </div>
  </div>
</section>

<section class="section">
  <div class="container contact-grid">
    <form class="card" method="post" action="<?= e(url('traitements/contact.php')) ?>">
      <?= csrf_field() ?>
      <h2>Formulaire de contact</h2>
      <div class="field"><label for="nom">Nom</label><input id="nom" name="nom" required <?= name_attrs() ?>></div>
      <div class="field"><label for="email">Email</label><input id="email" type="email" name="email" required></div>
      <?= phone_field('telephone', 'Téléphone (facultatif)', false) ?>
      <div class="field">
        <label for="objet">Objet</label>
        <select id="objet" name="objet" required>
          <option value="">Choisir</option>
          <option>Demande d'information</option>
          <option>Intervention en établissement</option>
          <option>Don / soutien</option>
          <option><?= e(CONTACT_OBJET_PARTENARIAT) ?></option>
          <option>Presse</option>
          <option>Autre</option>
        </select>
      </div>
      <div class="field"><label for="organisation">Organisation (facultatif)</label><input id="organisation" name="organisation" maxlength="160"></div>
      <div class="field"><label for="message">Message</label><textarea id="message" name="message" required></textarea></div>
      <button class="btn btn-dark" type="submit">Envoyer</button>
    </form>

    <aside>
      <div class="coord-box" id="coordonnees">
        <h2>Nos coordonnées</h2>
        <p><strong>Téléphone</strong><br><?= e(SITE_PHONE) ?></p>
        <p><strong>Email</strong><br><a href="mailto:<?= e(SITE_EMAIL) ?>"><?= e(SITE_EMAIL) ?></a></p>
        <p><strong>Adresse</strong><br><?= e(SITE_ADDRESS) ?></p>
      </div>
      <div class="map-frame" id="trouver">
        <iframe title="Carte Abidjan Cocody" src="https://www.openstreetmap.org/export/embed.html?bbox=-4.03%2C5.33%2C-3.95%2C5.39&amp;layer=mapnik&amp;marker=5.36%2C-3.99"></iframe>
      </div>
      <div id="reseaux" style="margin-top:18px">
        <h3>Réseaux sociaux</h3>
        <div class="socials">
          <?= social_links() ?>
        </div>
      </div>
      <p id="rejoindre" style="margin-top:18px"><a class="btn btn-dark" href="<?= e(url('nous-soutenir.php')) ?>#benevolat">Nous rejoindre</a></p>
    </aside>
  </div>
</section>

<section class="section section-alt">
  <div class="container" style="max-width:640px">
    <h2>Newsletter</h2>
    <p class="lead">Recevoir les actualités de l'association.</p>
    <form method="post" action="<?= e(url('traitements/newsletter.php')) ?>" class="grid-2" style="align-items:end">
      <?= csrf_field() ?>
      <div class="field" style="margin:0">
        <label for="nl">Email</label>
        <input id="nl" type="email" name="email" required placeholder="vous@exemple.com">
      </div>
      <button class="btn btn-dark" type="submit">S'inscrire</button>
    </form>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
