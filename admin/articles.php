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
        $titre = trim($_POST['titre'] ?? '');
        $slug = slugify(trim($_POST['slug'] ?? '') ?: $titre);
        $taken = db_one('SELECT id FROM articles WHERE slug = ? AND id <> ?', [$slug, $id]);
        if ($taken) {
            $slug .= '-' . date('His');
        }
        try {
            $image = admin_upload_image('image_fichier', 'articles') ?? (trim($_POST['image'] ?? '') ?: 'img/article-1.jpg');
        } catch (RuntimeException $e) {
            flash_set('error', $e->getMessage());
            header('Location: ' . url('admin/articles.php' . ($id ? '?edit=' . $id : '')));
            exit;
        }
        $data = [
            $titre,
            $slug,
            $image,
            trim($_POST['extrait'] ?? ''),
            text_to_html($_POST['contenu'] ?? ''),
            trim($_POST['auteur'] ?? '') ?: 'Rédaction Gouttes Rouges',
            (int) ($_POST['categorie_id'] ?: 1),
            $_POST['date_publication'] ?: date('Y-m-d'),
            ($_POST['statut'] ?? '') === 'brouillon' ? 'brouillon' : 'publie',
        ];
        if ($id > 0) {
            $db->prepare('UPDATE articles SET titre=?, slug=?, image=?, extrait=?, contenu=?, auteur=?, categorie_id=?, date_publication=?, statut=? WHERE id=?')
                ->execute([...$data, $id]);
            flash_set('success', 'Article modifié.');
        } else {
            $db->prepare('INSERT INTO articles (titre, slug, image, extrait, contenu, auteur, categorie_id, date_publication, statut) VALUES (?,?,?,?,?,?,?,?,?)')
                ->execute($data);
            flash_set('success', 'Article ajouté.');
        }
    }
    header('Location: ' . url('admin/articles.php'));
    exit;
}

$edit = null;
if ($db && isset($_GET['edit'])) {
    $edit = db_one('SELECT * FROM articles WHERE id = ?', [(int) $_GET['edit']]);
}
$articles = $db ? db_all('SELECT a.*, c.nom AS categorie FROM articles a LEFT JOIN categories c ON c.id = a.categorie_id ORDER BY a.date_publication DESC, a.id DESC') : fallback_articles();
$categories = $db ? db_all('SELECT * FROM categories ORDER BY nom') : [['id' => 1, 'nom' => 'Guides']];
$flash = flash_get();
$adminTitle = 'Articles';
require __DIR__ . '/includes/header.php';
?>
<?php if ($flash): ?><div class="flash flash-<?= e($flash['type']) ?>"><?= e($flash['message']) ?></div><?php endif; ?>
<?php if ($db): ?>
<form class="card admin-form" method="post" enctype="multipart/form-data" style="margin:20px 0">
  <h2><?= $edit ? 'Modifier l\'article' : 'Ajouter un article' ?></h2>
  <?= csrf_field() ?>
  <input type="hidden" name="action" value="save">
  <input type="hidden" name="id" value="<?= e((string) ($edit['id'] ?? '')) ?>">
  <input type="hidden" name="image" value="<?= e($edit['image'] ?? '') ?>">
  <div class="grid-2">
    <div class="field"><label>Titre</label><input name="titre" required value="<?= e($edit['titre'] ?? '') ?>"></div>
    <div class="field"><label>Adresse (slug) — laissé vide, elle est créée à partir du titre</label><input name="slug" value="<?= e($edit['slug'] ?? '') ?>"></div>
  </div>
  <div class="grid-2">
    <div class="field">
      <label>Image (JPG, PNG ou WEBP, 5 Mo max)</label>
      <input type="file" name="image_fichier" accept="image/jpeg,image/png,image/webp">
      <?php if (!empty($edit['image'])): ?>
        <img class="admin-thumb" src="<?= e(asset($edit['image'])) ?>" alt="Image actuelle">
      <?php endif; ?>
    </div>
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
    <div class="field"><label>Date de publication</label><input type="date" name="date_publication" value="<?= e($edit['date_publication'] ?? date('Y-m-d')) ?>"></div>
  </div>
  <div class="field"><label>Résumé (affiché dans les listes)</label><textarea name="extrait"><?= e($edit['extrait'] ?? '') ?></textarea></div>
  <div class="field"><label>Contenu — texte simple (une ligne vide = nouveau paragraphe) ou HTML</label><textarea name="contenu" style="min-height:260px"><?= e($edit['contenu'] ?? '') ?></textarea></div>
  <div class="field">
    <label>Statut</label>
    <select name="statut">
      <option value="publie" <?= ($edit['statut'] ?? '') === 'publie' ? 'selected' : '' ?>>Publié</option>
      <option value="brouillon" <?= ($edit['statut'] ?? '') === 'brouillon' ? 'selected' : '' ?>>Brouillon</option>
    </select>
  </div>
  <div class="admin-actions">
    <button class="btn btn-save" type="submit"><?= $edit ? 'Enregistrer les modifications' : 'Ajouter l\'article' ?></button>
    <?php if ($edit): ?><a class="btn btn-neutral" href="<?= e(url('admin/articles.php')) ?>">Annuler</a><?php endif; ?>
  </div>
</form>
<?php endif; ?>
<div class="table-scroll">
<table class="data">
  <thead><tr><th></th><th>Titre</th><th>Catégorie</th><th>Date</th><th>Statut</th><th></th></tr></thead>
  <tbody>
  <?php foreach ($articles as $article): ?>
    <tr>
      <td><img class="admin-thumb is-small" src="<?= e(asset($article['image'] ?? 'img/article-1.jpg')) ?>" alt=""></td>
      <td><?= e($article['titre']) ?></td>
      <td><?= e($article['categorie'] ?? '') ?></td>
      <td><?= e(format_date($article['date_publication'] ?? '')) ?></td>
      <td><?= ($article['statut'] ?? 'publie') === 'publie' ? 'Publié' : 'Brouillon' ?></td>
      <td>
        <?php if ($db && isset($article['id'])): ?>
          <div class="admin-actions">
            <?php if (($article['statut'] ?? 'publie') === 'publie'): ?>
              <a class="btn btn-neutral" href="<?= e(url('article.php?slug=' . $article['slug'])) ?>" target="_blank">Voir</a>
            <?php endif; ?>
            <a class="btn btn-edit" href="?edit=<?= (int) $article['id'] ?>">Modifier</a>
            <form method="post" onsubmit="return confirm('Supprimer cet article ?')">
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
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
