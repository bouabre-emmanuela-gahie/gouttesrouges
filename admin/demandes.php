<?php
require_once __DIR__ . '/includes/auth.php';
require_admin();
$db = pdo();

$statuts = ['nouvelle' => 'Nouvelle', 'en_cours' => 'En cours', 'acceptee' => 'Acceptée', 'refusee' => 'Refusée'];

if ($db && $_SERVER['REQUEST_METHOD'] === 'POST' && csrf_ok()) {
    $id = (int) ($_POST['id'] ?? 0);
    $action = $_POST['action'] ?? '';
    if ($action === 'delete') {
        $db->prepare('DELETE FROM demandes_partenariat WHERE id = ?')->execute([$id]);
        flash_set('success', 'Demande supprimée.');
    } elseif (isset($statuts[$action])) {
        $db->prepare('UPDATE demandes_partenariat SET statut = ? WHERE id = ?')->execute([$action, $id]);
    }
    header('Location: ' . url('admin/demandes.php' . (isset($_GET['statut']) ? '?statut=' . urlencode((string) $_GET['statut']) : '')));
    exit;
}

$filtre = isset($statuts[$_GET['statut'] ?? '']) ? $_GET['statut'] : null;
$demandes = $db ? db_all(
    'SELECT * FROM demandes_partenariat' . ($filtre ? ' WHERE statut = ?' : '') . ' ORDER BY created_at DESC',
    $filtre ? [$filtre] : []
) : [];
$flash = flash_get();
$adminTitle = 'Demandes de partenariat';
require __DIR__ . '/includes/header.php';
?>
<?php if ($flash): ?><div class="flash flash-<?= e($flash['type']) ?>"><?= e($flash['message']) ?></div><?php endif; ?>
<p>Demandes reçues via le formulaire de contact (objet « <?= e(CONTACT_OBJET_PARTENARIAT) ?> »).</p>
<div class="admin-filters">
  <a class="<?= $filtre === null ? 'is-active' : '' ?>" href="<?= e(url('admin/demandes.php')) ?>">Toutes</a>
  <?php foreach ($statuts as $code => $libelle): ?>
    <a class="<?= $filtre === $code ? 'is-active' : '' ?>" href="?statut=<?= e($code) ?>"><?= e($libelle) ?></a>
  <?php endforeach; ?>
</div>
<div class="admin-list">
  <?php foreach ($demandes as $demande): ?>
    <details class="admin-item<?= $demande['statut'] === 'nouvelle' ? ' is-new' : '' ?>">
      <summary>
        <span class="admin-item-main">
          <strong><?= e($demande['organisation']) ?></strong> — <?= e($demande['responsable']) ?>
          <small><?= e(excerpt((string) $demande['message'], 90)) ?></small>
        </span>
        <span class="admin-badge is-<?= e($demande['statut']) ?>"><?= e($statuts[$demande['statut']] ?? $demande['statut']) ?></span>
        <span class="admin-date"><?= e(format_date($demande['created_at'])) ?></span>
      </summary>
      <div class="admin-item-body">
        <p class="admin-meta">
          <a href="mailto:<?= e($demande['email']) ?>"><?= e($demande['email']) ?></a>
          <?php if (!empty($demande['telephone'])): ?> · <a href="tel:<?= e(str_replace(' ', '', $demande['telephone'])) ?>"><?= e($demande['telephone']) ?></a><?php endif; ?>
          <?php if (!empty($demande['type_partenariat'])): ?> · <?= e($demande['type_partenariat']) ?><?php endif; ?>
        </p>
        <div class="admin-message"><?= nl2br(e((string) $demande['message'])) ?></div>
        <div class="admin-actions">
          <a class="btn btn-dark" href="mailto:<?= e($demande['email']) ?>?subject=<?= e(rawurlencode('Partenariat Gouttes Rouges')) ?>">Répondre</a>
          <?php foreach (['en_cours' => 'btn-edit', 'acceptee' => 'btn-success', 'refusee' => 'btn-neutral'] as $code => $class): ?>
            <?php if ($demande['statut'] !== $code): ?>
              <form method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="id" value="<?= (int) $demande['id'] ?>">
                <button class="btn <?= $class ?>" name="action" value="<?= $code ?>" type="submit"><?= e($statuts[$code]) ?></button>
              </form>
            <?php endif; ?>
          <?php endforeach; ?>
          <form method="post" onsubmit="return confirm('Supprimer cette demande ?')">
            <?= csrf_field() ?>
            <input type="hidden" name="id" value="<?= (int) $demande['id'] ?>">
            <button class="btn btn-danger" name="action" value="delete" type="submit">Supprimer</button>
          </form>
        </div>
      </div>
    </details>
  <?php endforeach; ?>
  <?php if (!$demandes): ?>
    <p class="admin-empty">Aucune demande de partenariat<?= $filtre ? ' avec ce statut' : '' ?>.</p>
  <?php endif; ?>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
