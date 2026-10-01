<?php
require_once __DIR__ . '/includes/auth.php';
require_admin();
$db = pdo();

if ($db && isset($_GET['statut'], $_GET['id'])) {
    $db->prepare('UPDATE messages SET statut = ? WHERE id = ?')->execute([$_GET['statut'], (int) $_GET['id']]);
    header('Location: ' . url('admin/messages.php'));
    exit;
}

$messages = $db ? db_all('SELECT * FROM messages ORDER BY created_at DESC') : [];
$adminTitle = 'Messages';
require __DIR__ . '/includes/header.php';
?>
<p>Consulter, traiter et archiver les messages du formulaire de contact.</p>
<table class="data">
  <thead><tr><th>Nom</th><th>Objet</th><th>Message</th><th>Statut</th><th></th></tr></thead>
  <tbody>
  <?php foreach ($messages as $msg): ?>
    <tr>
      <td><?= e($msg['nom']) ?><br><small><?= e($msg['email']) ?></small></td>
      <td><?= e($msg['objet']) ?></td>
      <td><?= e(excerpt($msg['message'], 80)) ?></td>
      <td><?= e($msg['statut']) ?></td>
      <td>
        <div class="admin-actions">
          <a class="btn btn-success" href="?id=<?= (int) $msg['id'] ?>&statut=traite">Traiter</a>
          <a class="btn btn-neutral" href="?id=<?= (int) $msg['id'] ?>&statut=archive">Archiver</a>
        </div>
      </td>
    </tr>
  <?php endforeach; ?>
  <?php if (!$messages): ?>
    <tr><td colspan="5">Aucun message.</td></tr>
  <?php endif; ?>
  </tbody>
</table>
<?php require __DIR__ . '/includes/footer.php'; ?>
