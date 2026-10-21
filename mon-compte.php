<?php
require_once __DIR__ . '/includes/functions.php';

$user = current_user();
if (!$user) {
    redirect('connexion.php?redirect=mon-compte.php');
}

$dons = db_all(
    'SELECT d.*, t.libelle AS type_don
     FROM dons d
     JOIN donateurs don ON don.id = d.donateur_id
     LEFT JOIN types_dons t ON t.id = d.type_don_id
     WHERE don.email = ?
     ORDER BY d.created_at DESC',
    [$user['email']]
);
$statuts = ['en_attente' => 'En attente', 'recu' => 'Reçu', 'traite' => 'Traité'];

$pageTitle = 'Mon compte — Gouttes Rouges';
require __DIR__ . '/includes/header.php';
?>
<section class="section">
  <div class="container">
    <div class="account-head">
      <div>
        <p class="eyebrow">Mon compte</p>
        <h1>Bonjour <?= e($user['prenom']) ?></h1>
        <p class="lead"><?= e($user['email']) ?><?= $user['telephone'] ? ' · ' . e($user['telephone']) : '' ?></p>
      </div>
      <div class="hero-actions">
        <a class="btn btn-dark" href="<?= e(url('nous-soutenir.php')) ?>#don">Faire un don</a>
        <a class="btn btn-light" href="<?= e(url('deconnexion.php')) ?>">Se déconnecter</a>
      </div>
    </div>

    <h2>Mes dons</h2>
    <?php if ($dons): ?>
      <div class="table-scroll">
        <table class="data">
          <thead><tr><th>Date</th><th>Type</th><th>Montant / matériel</th><th>Statut</th><th></th></tr></thead>
          <tbody>
          <?php foreach ($dons as $don): ?>
            <tr>
              <td><?= e(format_date($don['created_at'])) ?></td>
              <td><?= e(ucfirst((string) ($don['type_don'] ?? ''))) ?></td>
              <td><?= e($don['montant'] ? number_format((float) $don['montant'], 0, ',', ' ') . ' XOF' : (($don['quantite'] ?? '') . ' × ' . ($don['materiel'] ?? ''))) ?></td>
              <td><?= e($don['montant'] && $don['statut'] !== 'en_attente' ? 'Payé' : ($statuts[$don['statut']] ?? (string) $don['statut'])) ?></td>
              <td>
                <?php if ($don['montant'] && $don['statut'] === 'en_attente'): ?>
                  <a class="btn btn-dark btn-small" href="<?= e(url('paiement.php?don=' . (int) $don['id'])) ?>">Payer</a>
                <?php elseif ($don['montant']): ?>
                  <a href="<?= e(url('paiement-effectue.php?don=' . (int) $don['id'])) ?>">Reçu <?= e(paiement_reference($don)) ?></a>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php else: ?>
      <p>Vous n'avez pas encore fait de don. <a href="<?= e(url('nous-soutenir.php')) ?>#don">Faire mon premier don</a></p>
    <?php endif; ?>
  </div>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
