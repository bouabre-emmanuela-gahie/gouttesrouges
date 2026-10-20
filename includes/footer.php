</main>
<div class="newsletter-bar">
  <div class="container newsletter-bar-inner">
    <div>
      <strong>Restez informé</strong>
      <p>Recevez les actualités, campagnes et rendez-vous de Gouttes Rouges.</p>
    </div>
    <form method="post" action="<?= e(url('traitements/newsletter.php')) ?>">
      <?= csrf_field() ?>
      <input type="email" name="email" required placeholder="Votre email">
      <button class="btn btn-dark" type="submit">S'inscrire</button>
    </form>
  </div>
</div>
<footer class="site-footer">
  <div class="container footer-top">
    <div class="footer-brand">
      <a class="logo" href="<?= e(url('index.php')) ?>">
        <img src="<?= e(asset('img/logo-blanc.png')) ?>" alt="Gouttes Rouges" width="600" height="109">
      </a>
      <p><?= e(SITE_TAGLINE) ?> Association engagée à Abidjan et dans les villes de l'intérieur.</p>
      <div class="socials" style="margin-top:16px">
        <?= social_links() ?>
      </div>
    </div>
    <div class="footer-col">
      <h4>Qui sommes-nous ?</h4>
      <a href="<?= e(url('qui-sommes-nous.php')) ?>#mission">Notre mission</a>
      <a href="<?= e(url('qui-sommes-nous.php')) ?>#equipe">Notre équipe</a>
      <a href="<?= e(url('qui-sommes-nous.php')) ?>#valeurs">Nos valeurs</a>
      <a href="<?= e(url('qui-sommes-nous.php')) ?>#partenaires">Les partenaires</a>
    </div>
    <div class="footer-col">
      <h4>Nos actions</h4>
      <a href="<?= e(url('nos-actions.php')) ?>#precarite">Distribution de matériel</a>
      <a href="<?= e(url('nos-actions.php')) ?>#education">Sensibilisation &amp; éducation</a>
      <a href="<?= e(url('nos-actions.php')) ?>#plaidoyer">Plaidoyer</a>
      <a href="<?= e(url('nos-actions.php')) ?>#leadership">Agir au-delà des protections</a>
      <a href="<?= e(url('nos-actions.php')) ?>#campagnes">Campagnes &amp; projets</a>
      <a href="<?= e(url('nos-actions.php')) ?>#actualites">Actualités &amp; événements</a>
    </div>
    <div class="footer-col">
      <h4>Ressources</h4>
      <a href="<?= e(url('ressources.php')) ?>#articles">Articles &amp; guides</a>
      <a href="<?= e(url('ressources.php')) ?>#faq">Foire aux questions</a>
      <a href="<?= e(url('ressources.php')) ?>#supports">Supports éducatifs</a>
      <a href="<?= e(url('ressources.php')) ?>#glossaire">Glossaire</a>
    </div>
    <div class="footer-col">
      <h4>Nous soutenir</h4>
      <a href="<?= e(url('nous-soutenir.php')) ?>#don">Faire un don</a>
      <a href="<?= e(url('nous-soutenir.php')) ?>#benevolat">Devenir bénévole</a>
      <a href="<?= e(url('nous-soutenir.php')) ?>#benevolat">Donner du temps</a>
    </div>
    <div class="footer-col">
      <h4>Contact</h4>
      <a href="<?= e(url('contact.php')) ?>">Formulaire de contact</a>
      <a href="<?= e(url('contact.php')) ?>#coordonnees">Nos coordonnées</a>
      <a href="<?= e(url('contact.php')) ?>#rejoindre">Nous rejoindre</a>
      <a href="<?= e(url('contact.php')) ?>#reseaux">Réseaux sociaux</a>
    </div>
  </div>
  <div class="container footer-bottom">
    <div class="footer-legal">
      <a href="<?= e(url('mentions-legales.php')) ?>">Mentions légales</a>
      <a href="<?= e(url('politique-confidentialite.php')) ?>">Politique de confidentialité</a>
      <a href="<?= e(url('conditions-utilisation.php')) ?>">Conditions d'utilisation</a>
      <a href="<?= e(url('plan-du-site.php')) ?>">Plan du site</a>
    </div>
    <div>© <?= date('Y') ?> Gouttes Rouges. Tous droits réservés.</div>
  </div>
</footer>
<script src="<?= e(asset('js/main.js')) ?>"></script>
</body>
</html>
