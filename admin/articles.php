<?php
require_once __DIR__ . '/includes/auth.php';
require_admin();

$db = pdo();
if ($db && ($_SERVER['REQUEST_METHOD'] === 'POST') && csrf_ok()) {
    $action = $_POST['action'] ?? '';
    if ($action === 'delete') {
        $db->prepare('DELETE FROM articles WHERE id = ?')->execute([(int) $_POST['id']]);
        flash_set('success', 'Article supprimé.');
    } elseif ($action === 'save') {
        $id = (int) ($_POST['id'] ?? 0);
        $data = [
            trim($_POST['titre'] ?? ''),
            trim($_POST['slug'] ?? ''),
            trim($_POST['image'] ?? 'img/article-1.jpg'),
            trim($_POST['extrait'] ?? ''),
            $_POST['contenu'] ?? '',
            trim($_POST['auteur'] ?? 'Rédaction'),
            (int) ($_POST['categorie_id'] ?: 1),
            $_POST['date_publication'] ?: date('Y-m-d'),
            $_POST['statut'] ?? 'publie',
        ];
        if ($id > 0) {
            $db->prepare('UPDATE articles SET titre=?, slug=?, image=?, extrait=?, contenu=?, auteur=?, categorie_id=?, date_publication=?, statut=? WHERE id=?')
                ->execute([...$data, $id]);
        } else {
            $db->prepare('INSERT INTO articles (titre, slug, image, extrait, contenu, auteur, categorie_id, date_publication, statut) VALUES (?,?,?,?,?,?,?,?,?)')
                ->execute($data);
        }
        flash_set('success', 'Article enregistré.');
    }
    header('Location: ' . url('admin/articles.php'));
    exit;
}

$edit = null;
if ($db && isset($_GET['edit'])) {
    $edit = db_one('SELECT * FROM articles WHERE id = ?', [(int) $_GET['edit']]);
}
$articles = $db ? db_all('SELECT a.*, c.nom AS categorie FROM articles a LEFT JOIN categories c ON c.id = a.categorie_id ORDER BY a.id DESC') : fallback_articles();
$categories = $db ? db_all('SELECT * FROM categories ORDER BY nom') : [['id' => 1, 'nom' => 'Guides']];
$flash = flash_get();
$adminTitle = 'Articles';
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
  <div class="grid-2">
    <div class="field"><label>Image (chemin assets)</label><input name="image" value="<?= e($edit['image'] ?? 'img/article-1.jpg') ?>"></div>
    <div class="field"><label>Auteur</label><input name="auteur" value="<?= e($edit['auteur'] ?? '') ?>"></div>
  </div>
  <div class="grid-2">
    <div class="field">
      <label>Catégorie</label>
      <select name="categorie_id">
        <?php foreach ($categories as $cat): ?>
          <option value="<?= (int) $cat['id'] ?>" <?= (int) ($edit['categorie_id'] ?? 0) === (int) $cat['id'] ? 'selected' : '' ?>><?= e($cat['nom']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="field"><label>Date</label><input type="date" name="date_publication" value="<?= e($edit['date_publication'] ?? date('Y-m-d')) ?>"></div>
  </div>
  <div class="field"><label>Extrait</label><textarea name="extrait"><?= e($edit['extrait'] ?? '') ?></textarea></div>
  <div class="field"><label>Contenu HTML</label><textarea name="contenu"><?= e($edit['contenu'] ?? '') ?></textarea></div>
  <div class="field">
    <label>Statut</label>
    <select name="statut">
      <option value="publie" <?= ($edit['statut'] ?? '') === 'publie' ? 'selected' : '' ?>>Publié</option>
      <option value="brouillon" <?= ($edit['statut'] ?? '') === 'brouillon' ? 'selected' : '' ?>>Brouillon</option>
    </select>
  </div>
  <button class="btn btn-save" type="submit"><?= $edit ? 'Mettre à jour' : 'Ajouter' ?></button>
</form>
<?php endif; ?>
<table class="data">
  <thead><tr><th>Titre</th><th>Catégorie</th><th>Date</th><th></th></tr></thead>
  <tbody>
  <?php foreach ($articles as $article): ?>
    <tr>
      <td><?= e($article['titre']) ?></td>
      <td><?= e($article['categorie'] ?? '') ?></td>
      <td><?= e($article['date_publication'] ?? '') ?></td>
      <td>
        <?php if ($db && isset($article['id'])): ?>
          <div class="admin-actions">
            <a class="btn btn-edit" href="?edit=<?= (int) $article['id'] ?>">Modifier</a>
            <form method="post" onsubmit="return confirm('Supprimer ?')">
              <?= csrf_field() ?>
              <input type="hidden" name="action" value="delete">
              <input type="hidden" name="id" value="<?= (int) $article['id'] ?>">
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
