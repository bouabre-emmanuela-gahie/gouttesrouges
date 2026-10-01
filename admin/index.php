<?php
require_once __DIR__ . '/includes/auth.php';
require_admin();
$adminTitle = 'Tableau de bord';
require __DIR__ . '/includes/header.php';
?>
<p>Vue d'ensemble des contenus et des demandes reçues.</p>
<div class="admin-cards">
  <article class="admin-card"><span>Articles</span><strong><?= db_count('articles') ?></strong></article>
  <article class="admin-card"><span>Campagnes</span><strong><?= db_count('campagnes') ?></strong></article>
  <article class="admin-card"><span>Dons</span><strong><?= db_count('dons') ?></strong></article>
  <article class="admin-card"><span>Messages</span><strong><?= db_count('messages') ?></strong></article>
</div>
<div class="admin-cards">
  <article class="admin-card"><span>Partenaires</span><strong><?= db_count('partenaires') ?></strong></article>
  <article class="admin-card"><span>Demandes partenariat</span><strong><?= db_count('demandes_partenariat') ?></strong></article>
  <article class="admin-card"><span>Bénévoles</span><strong><?= db_count('visiteurs') ?></strong></article>
  <article class="admin-card"><span>Newsletter</span><strong><?= db_count('newsletter') ?></strong></article>
</div>
<?php if (!pdo()): ?>
  <div class="flash flash-error">Base MySQL non connectée. Importez <code>sql/gouttes_rouges.sql</code> puis vérifiez <code>includes/config.php</code>. Les contenus publics s'affichent déjà via les données de secours.</div>
<?php endif; ?>
<?php require __DIR__ . '/includes/footer.php'; ?>
