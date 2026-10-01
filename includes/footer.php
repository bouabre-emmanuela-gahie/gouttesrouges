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
        <svg viewBox="0 0 28 36" aria-hidden="true">
          <path d="M14 1.5C14 1.5 2.5 14.2 2.5 22.2a11.5 11.5 0 1 0 23 0C25.5 14.2 14 1.5 14 1.5z" fill="#b3122c"/>
          <path d="M14 13.2c.2 3.4 2.7 5.2 2.7 8.1A2.7 2.7 0 1 1 11.3 21c0-2.8 2.5-4.6 2.7-7.8z" fill="#fff" opacity=".35"/>
        </svg>
        Gouttes Rouges
      </a>
      <p><?= e(SITE_TAGLINE) ?> Association engagée à Abidjan et dans les villes de l'intérieur.</p>
      <div class="socials" style="margin-top:16px">
        <a href="https://facebook.com" aria-label="Facebook" target="_blank" rel="noopener"><svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M14 9h3V6h-3c-2.2 0-4 1.8-4 4v2H8v3h2v7h3v-7h3l1-3h-4V10c0-.6.4-1 1-1z"/></svg></a>
        <a href="https://x.com" aria-label="X" target="_blank" rel="noopener"><svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M14.7 10.3 21 3h-2.3l-5.1 5.9L9.3 3H3l6.7 9.7L3 21h2.3l5.5-6.4L14.7 21H21l-6.3-10.7z"/></svg></a>
        <a href="https://instagram.com" aria-label="Instagram" target="_blank" rel="noopener"><svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M7 3h10a4 4 0 0 1 4 4v10a4 4 0 0 1-4 4H7a4 4 0 0 1-4-4V7a4 4 0 0 1 4-4zm10 2H7a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2zm-5 3.5A3.5 3.5 0 1 1 8.5 12 3.5 3.5 0 0 1 12 8.5zm4.8-.9a.9.9 0 1 1-.9.9.9.9 0 0 1 .9-.9z"/></svg></a>
        <a href="https://linkedin.com" aria-label="LinkedIn" target="_blank" rel="noopener"><svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M6.5 9H4V20h2.5V9zM5.2 4A1.6 1.6 0 1 0 5.2 7.2 1.6 1.6 0 0 0 5.2 4zM20 20h-2.5v-5.6c0-1.8-.8-2.4-1.8-2.4s-2 .9-2 2.5V20H11V9h2.4v1.5c.6-1 1.7-1.8 3.3-1.8 2.2 0 3.3 1.4 3.3 4.2V20z"/></svg></a>
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
      <a href="<?= e(url('nous-soutenir.php')) ?>#partenariat">Devenir partenaire</a>
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
