<?php
require_once __DIR__ . '/includes/auth.php';
require_admin();
$db = pdo();

if ($db && isset($_GET['statut'], $_GET['id'])) {
    $db->prepare('UPDATE dons SET statut = ? WHERE id = ?')->execute([$_GET['statut'], (int) $_GET['id']]);
    header('Location: ' . url('admin/dons.php'));
    exit;
}

$dons = $db ? db_all(
    'SELECT d.*, don.nom, don.prenom, don.email, t.libelle AS type_don, c.titre AS campagne
     FROM dons d
     LEFT JOIN donateurs don ON don.id = d.donateur_id
     LEFT JOIN types_dons t ON t.id = d.type_don_id
     LEFT JOIN campagnes c ON c.id = d.campagne_id
     ORDER BY d.created_at DESC'
) : [];
$adminTitle = 'Dons';
require __DIR__ . '/includes/header.php';
?>
<p>Consultation des donateurs, montants, campagnes et statuts.</p>
<table class="data">
  <thead>
    <tr><th>Donateur</th><th>Type</th><th>Montant / matériel</th><th>Campagne</th><th>Statut</th><th></th></tr>
  </thead>
  <tbody>
  <?php foreach ($dons as $don): ?>
    <tr>
      <td><?= e(($don['prenom'] ?? '') . ' ' . ($don['nom'] ?? '')) ?><br><small><?= e($don['email'] ?? '') ?></small></td>
      <td><?= e($don['type_don'] ?? '') ?></td>
      <td><?= e($don['montant'] ? $don['montant'] . ' XOF' : (($don['quantite'] ?? '') . ' × ' . ($don['materiel'] ?? ''))) ?></td>
      <td><?= e($don['campagne'] ?? 'Général') ?></td>
      <td><?= e($don['statut'] ?? '') ?></td>
      <td>
        <div class="admin-actions">
          <a class="btn btn-success" href="?id=<?= (int) $don['id'] ?>&statut=recu">Reçu</a>
          <a class="btn btn-edit" href="?id=<?= (int) $don['id'] ?>&statut=traite">Traité</a>
        </div>
      </td>
    </tr>
  <?php endforeach; ?>
  <?php if (!$dons): ?>
    <tr><td colspan="6">Aucun don enregistré pour le moment.</td></tr>
  <?php endif; ?>
  </tbody>
</table>
<?php require __DIR__ . '/includes/footer.php'; ?>
