<?php
require_once __DIR__ . '/includes/auth.php';
require_admin();
$db = pdo();

if ($db && $_SERVER['REQUEST_METHOD'] === 'POST' && csrf_ok()) {
    $action = $_POST['action'] ?? '';
    if ($action === 'delete') {
        $db->prepare('DELETE FROM partenaires WHERE id = ?')->execute([(int) $_POST['id']]);
    } else {
        $id = (int) ($_POST['id'] ?? 0);
        $data = [
            trim($_POST['nom'] ?? ''),
            trim($_POST['logo'] ?? ''),
            trim($_POST['site_web'] ?? ''),
            trim($_POST['description'] ?? ''),
        ];
        if ($id > 0) {
            $db->prepare('UPDATE partenaires SET nom=?, logo=?, site_web=?, description=? WHERE id=?')->execute([...$data, $id]);
        } else {
            $db->prepare('INSERT INTO partenaires (nom, logo, site_web, description) VALUES (?,?,?,?)')->execute($data);
        }
    }
    header('Location: ' . url('admin/partenaires.php'));
    exit;
}

$edit = ($db && isset($_GET['edit'])) ? db_one('SELECT * FROM partenaires WHERE id = ?', [(int) $_GET['edit']]) : null;
$partenaires = $db ? db_all('SELECT * FROM partenaires ORDER BY nom') : fallback_partenaires();
$adminTitle = 'Partenaires';
require __DIR__ . '/includes/header.php';
?>
<?php if ($db): ?>
<form class="card" method="post" style="margin:20px 0">
  <?= csrf_field() ?>
  <input type="hidden" name="id" value="<?= e((string) ($edit['id'] ?? '')) ?>">
  <div class="grid-2">
    <div class="field"><label>Nom</label><input name="nom" required value="<?= e($edit['nom'] ?? '') ?>"></div>
    <div class="field"><label>Site web</label><input name="site_web" value="<?= e($edit['site_web'] ?? '') ?>"></div>
  </div>
  <div class="field"><label>Logo (chemin)</label><input name="logo" value="<?= e($edit['logo'] ?? '') ?>"></div>
  <div class="field"><label>Description</label><textarea name="description"><?= e($edit['description'] ?? '') ?></textarea></div>
  <button class="btn btn-save" type="submit"><?= $edit ? 'Mettre à jour' : 'Ajouter' ?></button>
</form>
<?php endif; ?>
<table class="data">
  <thead><tr><th>Nom</th><th></th></tr></thead>
  <tbody>
  <?php foreach ($partenaires as $p): ?>
    <tr>
      <td><?= e($p['nom']) ?></td>
      <td>
        <?php if ($db && isset($p['id'])): ?>
          <div class="admin-actions">
            <a class="btn btn-edit" href="?edit=<?= (int) $p['id'] ?>">Modifier</a>
            <form method="post" onsubmit="return confirm('Supprimer ?')">
              <?= csrf_field() ?>
              <input type="hidden" name="action" value="delete">
              <input type="hidden" name="id" value="<?= (int) $p['id'] ?>">
              <button class="btn btn-danger" type="submit">Supprimer</button>
            </form>
          </div>
        <?php endif; ?>
      </td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
<?php require __DIR__ . '/includes/footer.php'; ?>
