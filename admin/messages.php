<?php
require_once __DIR__ . '/includes/auth.php';
require_admin();
$db = pdo();

$statuts = ['nouveau' => 'Nouveau', 'traite' => 'Traité', 'archive' => 'Archivé'];

if ($db && $_SERVER['REQUEST_METHOD'] === 'POST' && csrf_ok()) {
    $id = (int) ($_POST['id'] ?? 0);
    $action = $_POST['action'] ?? '';
    if ($action === 'delete') {
        $db->prepare('DELETE FROM messages WHERE id = ?')->execute([$id]);
        flash_set('success', 'Message supprimé.');
    } elseif (isset($statuts[$action])) {
        $db->prepare('UPDATE messages SET statut = ? WHERE id = ?')->execute([$action, $id]);
    }
    header('Location: ' . url('admin/messages.php' . (isset($_GET['statut']) ? '?statut=' . urlencode((string) $_GET['statut']) : '')));
    exit;
}

$filtre = isset($statuts[$_GET['statut'] ?? '']) ? $_GET['statut'] : null;
$messages = $db ? db_all(
    'SELECT * FROM messages' . ($filtre ? ' WHERE statut = ?' : '') . ' ORDER BY created_at DESC',
    $filtre ? [$filtre] : []
) : [];
$flash = flash_get();
$adminTitle = 'Messages';
require __DIR__ . '/includes/header.php';
?>
<?php if ($flash): ?><div class="flash flash-<?= e($flash['type']) ?>"><?= e($flash['message']) ?></div><?php endif; ?>
<p>Messages reçus via le formulaire de contact. Cliquez sur un message pour le lire en entier.</p>
<div class="admin-filters">
  <a class="<?= $filtre === null ? 'is-active' : '' ?>" href="<?= e(url('admin/messages.php')) ?>">Tous</a>
  <?php foreach ($statuts as $code => $libelle): ?>
    <a class="<?= $filtre === $code ? 'is-active' : '' ?>" href="?statut=<?= e($code) ?>"><?= e($libelle) ?></a>
  <?php endforeach; ?>
</div>
<div class="admin-list">
  <?php foreach ($messages as $msg): ?>
    <details class="admin-item<?= $msg['statut'] === 'nouveau' ? ' is-new' : '' ?>">
      <summary>
        <span class="admin-item-main">
          <strong><?= e($msg['nom']) ?></strong> — <?= e($msg['objet']) ?>
          <small><?= e(excerpt($msg['message'], 90)) ?></small>
        </span>
        <span class="admin-badge is-<?= e($msg['statut']) ?>"><?= e($statuts[$msg['statut']] ?? $msg['statut']) ?></span>
        <span class="admin-date"><?= e(format_date($msg['created_at'])) ?></span>
      </summary>
      <div class="admin-item-body">
        <p class="admin-meta">
          <a href="mailto:<?= e($msg['email']) ?>?subject=<?= e(rawurlencode('Re: ' . $msg['objet'])) ?>"><?= e($msg['email']) ?></a>
          <?php if (!empty($msg['telephone'])): ?> · <a href="tel:<?= e(str_replace(' ', '', $msg['telephone'])) ?>"><?= e($msg['telephone']) ?></a><?php endif; ?>
        </p>
        <div class="admin-message"><?= nl2br(e($msg['message'])) ?></div>
        <div class="admin-actions">
          <a class="btn btn-dark" href="mailto:<?= e($msg['email']) ?>?subject=<?= e(rawurlencode('Re: ' . $msg['objet'])) ?>">Répondre</a>
          <?php foreach (['traite' => ['Marquer traité', 'btn-success'], 'archive' => ['Archiver', 'btn-neutral']] as $code => [$label, $class]): ?>
            <?php if ($msg['statut'] !== $code): ?>
              <form method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="id" value="<?= (int) $msg['id'] ?>">
                <button class="btn <?= $class ?>" name="action" value="<?= $code ?>" type="submit"><?= $label ?></button>
              </form>
            <?php endif; ?>
          <?php endforeach; ?>
          <form method="post" onsubmit="return confirm('Supprimer ce message ?')">
            <?= csrf_field() ?>
            <input type="hidden" name="id" value="<?= (int) $msg['id'] ?>">
            <button class="btn btn-danger" name="action" value="delete" type="submit">Supprimer</button>
          </form>
        </div>
      </div>
    </details>
  <?php endforeach; ?>
  <?php if (!$messages): ?>
    <p class="admin-empty">Aucun message<?= $filtre ? ' avec ce statut' : '' ?>.</p>
  <?php endif; ?>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
