<?php
require_once __DIR__ . '/includes/icons.php';
$pageTitle = 'Nous soutenir — Gouttes Rouges';
$pageDescription = 'Faire un don financier ou matériel ou devenir bénévole pour Gouttes Rouges.';
require __DIR__ . '/includes/header.php';

$campagnes = get_campagnes();
$partenaires = get_partenaires();
$temoignages = get_temoignages();
$donateur = current_user();
$produits = don_produits();
$retourDon = urlencode('nous-soutenir.php#don');
$loginBox = '<div class="donate-login"><p>Connectez-vous à votre compte pour faire un don et suivre vos contributions.</p>'
    . '<div class="hero-actions"><a class="btn btn-dark" href="' . e(url('connexion.php?redirect=' . $retourDon)) . '">Se connecter</a>'
    . '<a class="btn btn-light" href="' . e(url('inscription.php?redirect=' . $retourDon)) . '">Créer un compte</a></div></div>';
?>

<section class="hero">
  <div class="container hero-grid">
    <div>
      <h1>Nous soutenir</h1>
      <p class="lead">Votre contribution financière ou matérielle permet d'acheter des protections, d'organiser des ateliers et d'accompagner les filles là où le besoin est le plus urgent.</p>
      <div class="hero-actions">
        <a class="btn btn-dark" href="#don">Faire un don financier</a>
        <a class="btn btn-light" href="#pourquoi">En savoir plus</a>
      </div>
    </div>
    <div class="media-frame">
      <img src="<?= e(asset('img/terrain-stand.jpg')) ?>" alt="Stand de distribution de protections Gouttes Rouges">
    </div>
  </div>
</section>

<section class="section section-alt" id="pourquoi">
  <div class="container">
    <div class="section-head">
      <h2 class="section-title">Pourquoi soutenir Gouttes Rouges ?</h2>
      <p class="lead">Parce que trop de filles manquent encore l'école, l'information et les protections. Votre soutien finance l'action, pas le silence.</p>
    </div>
    <div class="grid-3">
      <article class="card">
        <h3>Faire un don financier</h3>
        <p>Chaque montant permet d'acheter des kits, de former des relais et de mener des campagnes de sensibilisation.</p>
        <a class="btn btn-dark" href="#don">Je donne</a>
      </article>
      <article class="card">
        <h3>Donner des protections</h3>
        <p>Serviettes, culottes menstruelles et produits d'hygiène neufs sont triés puis distribués aux bénéficiaires.</p>
        <a class="btn btn-dark" href="#don-materiel">Je donne</a>
      </article>
      <article class="card">
        <h3>Donner du temps</h3>
        <p>Ateliers, distributions, logistique ou communication : rejoignez nos bénévoles sur le terrain.</p>
        <a class="btn btn-light" href="#benevolat">Devenir bénévole</a>
      </article>
    </div>
  </div>
</section>

<section class="section" id="don">
  <div class="container">
    <div class="section-head">
      <h2 class="section-title">Formulaire de don</h2>
    </div>
    <div class="donate-split">
      <div class="donate-grid">
      <form class="card donate-card" method="post" action="<?= e(url('traitements/don.php')) ?>" data-amounts>
        <h2>Don financier</h2>
        <?= csrf_field() ?>
        <input type="hidden" name="type_don" value="financier">
        <input type="hidden" name="montant" value="5000">
        <div class="amount-row">
          <button type="button" class="amount-btn is-selected" data-amount="5000">5000 XOF</button>
          <button type="button" class="amount-btn" data-amount="15000">15000 XOF</button>
          <button type="button" class="amount-btn" data-amount="25000">25000 XOF</button>
          <button type="button" class="amount-btn" data-amount="100000">100000 XOF</button>
        </div>
        <div class="field">
          <label for="montant_libre">Autre montant</label>
          <input type="number" min="100" step="100" name="montant_libre" id="montant_libre" placeholder="Autre montant (XOF)">
        </div>
        <?php if ($donateur): ?>
          <p class="donate-user">Don au nom de <strong><?= e($donateur['prenom'] . ' ' . $donateur['nom']) ?></strong> (<?= e($donateur['email']) ?>)</p>
          <div class="field">
            <label for="fin_message">Message</label>
            <textarea id="fin_message" name="message" maxlength="1000" placeholder="Un mot pour l'équipe"></textarea>
          </div>
          <button class="btn btn-dark" type="submit" style="width:100%">Valider le don</button>
        <?php else: ?>
          <?= $loginBox ?>
        <?php endif; ?>
      </form>

      <form class="card donate-card" id="don-materiel" method="post" action="<?= e(url('traitements/don.php')) ?>">
        <h2>Don matériel</h2>
        <?= csrf_field() ?>
        <input type="hidden" name="type_don" value="materiel">
        <div class="field">
          <label for="materiel">Choisir un produit</label>
          <select id="materiel" name="materiel" required>
            <option value="">Choisir un produit</option>
            <?php foreach ($produits as $produit): ?>
              <option><?= e($produit) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="field">
          <label for="quantite">Quantité</label>
          <input id="quantite" type="number" min="1" max="100000" name="quantite" value="1" required>
        </div>
        <?php if ($donateur): ?>
          <p class="donate-user">Don au nom de <strong><?= e($donateur['prenom'] . ' ' . $donateur['nom']) ?></strong> (<?= e($donateur['email']) ?>)</p>
          <div class="field">
            <label for="mat_campagne">Campagne concernée</label>
            <select id="mat_campagne" name="campagne_id">
              <option value="">Don général</option>
              <?php foreach ($campagnes as $campagne): ?>
                <option value="<?= e((string) $campagne['id']) ?>"><?= e($campagne['titre']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="field">
            <label for="mat_message">Message</label>
            <textarea id="mat_message" name="message" maxlength="1000" placeholder="Précisez le lieu de dépôt si besoin"></textarea>
          </div>
          <button class="btn btn-light" type="submit" style="width:100%">Je confirme le don</button>
        <?php else: ?>
          <?= $loginBox ?>
        <?php endif; ?>
      </form>
      </div>
      <aside class="donate-visual">
        <img src="<?= e(asset('img/terrain-groupe.jpg')) ?>" alt="Jeunes réunis par Gouttes Rouges">
        <div class="caption">
          <h3>Aidez des filles comme Awa à rester à l'école.</h3>
          <p>Votre don finance des kits, des ateliers et un suivi digne, à Abidjan comme à l'intérieur.</p>
        </div>
      </aside>
    </div>
  </div>
</section>

<section class="section section-alt" id="utilisation">
  <div class="container">
    <div class="section-head">
      <h2 class="section-title">Comment sont utilisés vos dons ?</h2>
    </div>
    <div class="steps">
      <article class="step">
        <div class="step-num">1</div>
        <div>
          <h3>Collecte des dons</h3>
          <p>Les dons financiers et matériels sont reçus, enregistrés et orientés vers les campagnes en cours.</p>
        </div>
      </article>
      <article class="step">
        <div class="step-num">2</div>
        <div>
          <h3>Achat des protections</h3>
          <p>Les fonds servent à constituer des kits adaptés : serviettes, culottes, savon et notices d'utilisation.</p>
        </div>
      </article>
      <article class="step">
        <div class="step-num">3</div>
        <div>
          <h3>Distribution aux bénéficiaires</h3>
          <p>Les kits sont remis dans les écoles, les quartiers et lors des campagnes, avec un temps d'éducation.</p>
        </div>
      </article>
      <article class="step">
        <div class="step-num">4</div>
        <div>
          <h3>Suivi et impact</h3>
          <p>Nous documentons les distributions, recueillons les retours et publions les indicateurs d'impact.</p>
        </div>
      </article>
    </div>
  </div>
</section>

<section class="section" id="benevolat">
  <div class="container">
    <div class="section-head">
      <h2 class="section-title">Devenir bénévole</h2>
      <p class="lead">Donnez du temps : ateliers, distributions, logistique ou communication.</p>
    </div>
    <form class="card" method="post" action="<?= e(url('traitements/benevole.php')) ?>" style="max-width:820px;margin:0 auto">
      <?= csrf_field() ?>
      <div class="grid-2">
        <div class="field"><label for="ben_nom">Nom</label><input id="ben_nom" name="nom" required <?= name_attrs() ?>></div>
        <div class="field"><label for="ben_prenom">Prénom</label><input id="ben_prenom" name="prenom" required <?= name_attrs() ?>></div>
      </div>
      <div class="grid-2">
        <div class="field"><label for="ben_email">Email</label><input id="ben_email" type="email" name="email" required></div>
        <?= phone_field('ben_tel') ?>
      </div>
      <div class="grid-2">
        <div class="field"><label for="ben_ville">Ville</label><input id="ben_ville" name="ville" required <?= name_attrs() ?>></div>
        <div class="field">
          <label for="ben_domaine">Domaine d'intérêt</label>
          <select id="ben_domaine" name="domaine_interet" required>
            <option value="">Choisir</option>
            <option>Sensibilisation</option>
            <option>Distribution</option>
            <option>Communication</option>
            <option>Logistique</option>
            <option>Plaidoyer</option>
          </select>
        </div>
      </div>
      <div class="field"><label for="ben_motivation">Motivation</label><textarea id="ben_motivation" name="motivation" required></textarea></div>
      <button class="btn btn-dark" type="submit">Envoyer ma candidature</button>
    </form>
  </div>
</section>

<section class="section">
  <div class="container">
    <p class="kicker">Ils soutiennent la cause</p>
    <?= partners_grid($partenaires) ?>
  </div>
</section>

<section class="section section-alt">
  <div class="container">
    <div class="section-head">
      <h2 class="section-title">Témoignages</h2>
    </div>
    <div class="grid-2">
      <?php foreach ($temoignages as $item): ?>
        <article class="card">
          <div class="quote-mark">“</div>
          <blockquote><?= e($item['citation']) ?></blockquote>
          <div class="person">
            <img class="avatar" src="<?= e(asset($item['photo'])) ?>" alt="">
            <div>
              <strong><?= e($item['nom']) ?></strong>
              <span><?= e($item['role']) ?></span>
            </div>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="cta-band">
  <div class="container">
    <h2>Je soutiens Gouttes Rouges</h2>
    <p>Un geste, une protection, une fille qui reste à l'école. Agissez maintenant.</p>
    <a class="btn btn-ghost" href="#don">Faire un don maintenant</a>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
