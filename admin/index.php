<?php
require_once __DIR__ . '/includes/auth.php';
require_admin();

$db = pdo();
$nouveauxMessages = $db ? (int) $db->query("SELECT COUNT(*) FROM messages WHERE statut = 'nouveau'")->fetchColumn() : 0;
$nouvellesDemandes = $db ? (int) $db->query("SELECT COUNT(*) FROM demandes_partenariat WHERE statut = 'nouvelle'")->fetchColumn() : 0;
$derniersMessages = db_all('SELECT * FROM messages ORDER BY created_at DESC LIMIT 5');
$dernieresDemandes = db_all('SELECT * FROM demandes_partenariat ORDER BY created_at DESC LIMIT 5');

$cartes = [
    ['Articles', db_count('articles'), 'admin/articles.php', 'Ajouter / modifier'],
    ['Messages', db_count('messages'), 'admin/messages.php', $nouveauxMessages . ' non lu(s)'],
    ['Demandes de partenariat', db_count('demandes_partenariat'), 'admin/demandes.php', $nouvellesDemandes . ' nouvelle(s)'],
    ['Dons', db_count('dons'), 'admin/dons.php', 'Suivre les dons'],
    ['Comptes donateurs', db_count('utilisateurs'), null, 'Inscrits sur le site'],
    ['Partenaires (logos)', db_count('partenaires'), 'admin/partenaires.php', 'Ils soutiennent la cause'],
    ['Bénévoles', db_count('visiteurs'), null, 'Candidatures reçues'],
    ['Newsletter', db_count('newsletter'), null, 'Inscrits'],
];

$adminTitle = 'Tableau de bord';
require __DIR__ . '/includes/header.php';
?>
<p>Vue d'ensemble des contenus et des demandes reçues.</p>
<div class="admin-quick">
  <a class="btn btn-save" href="<?= e(url('admin/articles.php')) ?>">+ Ajouter un article</a>
  <a class="btn btn-neutral" href="<?= e(url('admin/messages.php?statut=nouveau')) ?>">Messages non lus (<?= $nouveauxMessages ?>)</a>
  <a class="btn btn-neutral" href="<?= e(url('admin/demandes.php?statut=nouvelle')) ?>">Nouvelles demandes (<?= $nouvellesDemandes ?>)</a>
</div>
<div class="admin-cards">
  <?php foreach ($cartes as [$label, $count, $lien, $note]): ?>
    <?php if ($lien): ?><a class="admin-card is-link" href="<?= e(url($lien)) ?>"><?php else: ?><article class="admin-card"><?php endif; ?>
      <span><?= e($label) ?></span>
      <strong><?= $count ?></strong>
      <small><?= e($note) ?></small>
    <?= $lien ? '</a>' : '</article>' ?>
  <?php endforeach; ?>
</div>

<div class="admin-panels">
  <section class="card">
    <h2>Derniers messages</h2>
    <?php foreach ($derniersMessages as $msg): ?>
      <p class="admin-line">
        <a href="<?= e(url('admin/messages.php')) ?>"><strong><?= e($msg['nom']) ?></strong> — <?= e($msg['objet']) ?></a>
        <small><?= e(format_date($msg['created_at'])) ?><?= $msg['statut'] === 'nouveau' ? ' · non lu' : '' ?></small>
      </p>
    <?php endforeach; ?>
    <?php if (!$derniersMessages): ?><p class="admin-empty">Aucun message pour le moment.</p><?php endif; ?>
  </section>
  <section class="card">
    <h2>Dernières demandes de partenariat</h2>
    <?php foreach ($dernieresDemandes as $demande): ?>
      <p class="admin-line">
        <a href="<?= e(url('admin/demandes.php')) ?>"><strong><?= e($demande['organisation']) ?></strong> — <?= e($demande['responsable']) ?></a>
        <small><?= e(format_date($demande['created_at'])) ?><?= $demande['statut'] === 'nouvelle' ? ' · nouvelle' : '' ?></small>
      </p>
    <?php endforeach; ?>
    <?php if (!$dernieresDemandes): ?><p class="admin-empty">Aucune demande pour le moment.</p><?php endif; ?>
  </section>
</div>
<?php if (!$db): ?>
  <div class="flash flash-error">Base MySQL non connectée. Importez <code>sql/gouttes_rouges.sql</code> puis vérifiez <code>includes/config.php</code>. Les contenus publics s'affichent déjà via les données de secours.</div>
<?php endif; ?>
<?php require __DIR__ . '/includes/footer.php'; ?>
