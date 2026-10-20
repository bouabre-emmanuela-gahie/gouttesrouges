<?php
require_once __DIR__ . '/includes/auth.php';
require_admin();
$db = pdo();

if ($db && $_SERVER['REQUEST_METHOD'] === 'POST' && csrf_ok()) {
    $action = $_POST['action'] ?? '';
    if ($action === 'delete') {
        $db->prepare('DELETE FROM partenaires WHERE id = ?')->execute([(int) $_POST['id']]);
        flash_set('success', 'Partenaire supprimé.');
    } else {
        $id = (int) ($_POST['id'] ?? 0);
        try {
            $logo = admin_upload_image('logo_fichier', 'partenaires') ?? trim($_POST['logo'] ?? '');
        } catch (RuntimeException $e) {
            flash_set('error', $e->getMessage());
            header('Location: ' . url('admin/partenaires.php' . ($id ? '?edit=' . $id : '')));
            exit;
        }
        $data = [
            trim($_POST['nom'] ?? ''),
            $logo,
            trim($_POST['site_web'] ?? ''),
            trim($_POST['description'] ?? ''),
        ];
        if ($id > 0) {
            $db->prepare('UPDATE partenaires SET nom=?, logo=?, site_web=?, description=? WHERE id=?')->execute([...$data, $id]);
        } else {
            $db->prepare('INSERT INTO partenaires (nom, logo, site_web, description) VALUES (?,?,?,?)')->execute($data);
        }
        flash_set('success', 'Partenaire enregistré.');
    }
    header('Location: ' . url('admin/partenaires.php'));
    exit;
}

$edit = ($db && isset($_GET['edit'])) ? db_one('SELECT * FROM partenaires WHERE id = ?', [(int) $_GET['edit']]) : null;
$partenaires = $db ? db_all('SELECT * FROM partenaires ORDER BY nom') : fallback_partenaires();
$flash = flash_get();
$adminTitle = 'Partenaires';
require __DIR__ . '/includes/header.php';
?>
<?php if ($flash): ?><div class="flash flash-<?= e($flash['type']) ?>"><?= e($flash['message']) ?></div><?php endif; ?>
<p>Logos affichés dans la section « Ils soutiennent la cause » (accueil, Qui sommes-nous, Nous soutenir).</p>
<?php if ($db): ?>
<form class="card admin-form" method="post" enctype="multipart/form-data" style="margin:20px 0">
  <h2><?= $edit ? 'Modifier le partenaire' : 'Ajouter un partenaire' ?></h2>
  <?= csrf_field() ?>
  <input type="hidden" name="id" value="<?= e((string) ($edit['id'] ?? '')) ?>">
  <input type="hidden" name="logo" value="<?= e($edit['logo'] ?? '') ?>">
  <div class="grid-2">
    <div class="field"><label>Nom</label><input name="nom" required value="<?= e($edit['nom'] ?? '') ?>"></div>
    <div class="field"><label>Site web (facultatif, https://…)</label><input name="site_web" type="url" value="<?= e($edit['site_web'] ?? '') ?>"></div>
  </div>
  <div class="field">
    <label>Logo (PNG de préférence, fond transparent ou blanc)</label>
    <input type="file" name="logo_fichier" accept="image/jpeg,image/png,image/webp">
    <?php if (!empty($edit['logo'])): ?>
      <img class="admin-thumb is-logo" src="<?= e(asset($edit['logo'])) ?>" alt="Logo actuel">
    <?php endif; ?>
  </div>
  <div class="field"><label>Description</label><textarea name="description"><?= e($edit['description'] ?? '') ?></textarea></div>
  <div class="admin-actions">
    <button class="btn btn-save" type="submit"><?= $edit ? 'Mettre à jour' : 'Ajouter' ?></button>
    <?php if ($edit): ?><a class="btn btn-neutral" href="<?= e(url('admin/partenaires.php')) ?>">Annuler</a><?php endif; ?>
  </div>
</form>
<?php endif; ?>
<table class="data">
  <thead><tr><th>Logo</th><th>Nom</th><th></th></tr></thead>
  <tbody>
  <?php foreach ($partenaires as $p): ?>
    <tr>
      <td><?php if (!empty($p['logo'])): ?><img class="admin-thumb is-logo is-small" src="<?= e(asset($p['logo'])) ?>" alt=""><?php endif; ?></td>
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
