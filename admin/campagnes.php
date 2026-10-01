<?php
require_once __DIR__ . '/includes/auth.php';
require_admin();
$db = pdo();

if ($db && $_SERVER['REQUEST_METHOD'] === 'POST' && csrf_ok()) {
    $action = $_POST['action'] ?? '';
    if ($action === 'delete') {
        $db->prepare('DELETE FROM campagnes WHERE id = ?')->execute([(int) $_POST['id']]);
        flash_set('success', 'Campagne supprimée.');
    } elseif ($action === 'save') {
        $id = (int) ($_POST['id'] ?? 0);
        $data = [
            trim($_POST['titre'] ?? ''),
            trim($_POST['slug'] ?? ''),
            trim($_POST['image'] ?? 'img/campagne-1.jpg'),
            trim($_POST['description'] ?? ''),
            $_POST['contenu'] ?? '',
            $_POST['date_debut'] ?: date('Y-m-d'),
            $_POST['date_fin'] ?: null,
            $_POST['statut'] ?? 'publie',
        ];
        if ($id > 0) {
            $db->prepare('UPDATE campagnes SET titre=?, slug=?, image=?, description=?, contenu=?, date_debut=?, date_fin=?, statut=? WHERE id=?')
                ->execute([...$data, $id]);
        } else {
            $db->prepare('INSERT INTO campagnes (titre, slug, image, description, contenu, date_debut, date_fin, statut) VALUES (?,?,?,?,?,?,?,?)')
                ->execute($data);
        }
        flash_set('success', 'Campagne enregistrée.');
    }
    header('Location: ' . url('admin/campagnes.php'));
    exit;
}

$edit = ($db && isset($_GET['edit'])) ? db_one('SELECT * FROM campagnes WHERE id = ?', [(int) $_GET['edit']]) : null;
$campagnes = $db ? db_all('SELECT * FROM campagnes ORDER BY date_debut DESC') : fallback_campagnes();
$flash = flash_get();
$adminTitle = 'Campagnes';
require __DIR__ . '/includes/header.php';
?>
<?php if ($flash): ?><div class="flash flash-<?= e($flash['type']) ?>"><?= e($flash['message']) ?></div><?php endif; ?>
<?php if ($db): ?>
<form class="card" method="post" style="margin:20px 0">
  <?= csrf_field() ?>
  <input type="hidden" name="action" value="save">
  <input type="hidden" name="id" value="<?= e((string) ($edit['id'] ?? '')) ?>">
  <div class="grid-2">
    <div class="field"><label>Titre</label><input name="titre" required value="<?= e($edit['titre'] ?? '') ?>"></div>
    <div class="field"><label>Slug</label><input name="slug" required value="<?= e($edit['slug'] ?? '') ?>"></div>
  </div>
  <div class="field"><label>Image</label><input name="image" value="<?= e($edit['image'] ?? 'img/campagne-1.jpg') ?>"></div>
  <div class="grid-2">
    <div class="field"><label>Début</label><input type="date" name="date_debut" value="<?= e($edit['date_debut'] ?? '') ?>"></div>
    <div class="field"><label>Fin</label><input type="date" name="date_fin" value="<?= e($edit['date_fin'] ?? '') ?>"></div>
  </div>
  <div class="field"><label>Description</label><textarea name="description"><?= e($edit['description'] ?? '') ?></textarea></div>
  <div class="field"><label>Contenu</label><textarea name="contenu"><?= e($edit['contenu'] ?? '') ?></textarea></div>
  <div class="field">
    <label>Statut</label>
    <select name="statut">
      <option value="publie">Publié</option>
      <option value="brouillon">Brouillon</option>
    </select>
  </div>
  <button class="btn btn-save" type="submit"><?= $edit ? 'Mettre à jour' : 'Ajouter' ?></button>
</form>
<?php endif; ?>
<table class="data">
  <thead><tr><th>Titre</th><th>Dates</th><th></th></tr></thead>
  <tbody>
  <?php foreach ($campagnes as $campagne): ?>
    <tr>
      <td><?= e($campagne['titre']) ?></td>
      <td><?= e($campagne['date_debut'] ?? '') ?></td>
      <td>
        <?php if ($db && isset($campagne['id'])): ?>
          <div class="admin-actions">
            <a class="btn btn-edit" href="?edit=<?= (int) $campagne['id'] ?>">Modifier</a>
            <form method="post" onsubmit="return confirm('Supprimer ?')">
              <?= csrf_field() ?>
              <input type="hidden" name="action" value="delete">
              <input type="hidden" name="id" value="<?= (int) $campagne['id'] ?>">
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
