<?php
require_once __DIR__ . '/includes/functions.php';

$donId = (int) ($_GET['don'] ?? 0);
$user = current_user();
if (!$user) {
    redirect('connexion.php?redirect=mon-compte.php');
}

$don = don_du_donateur($donId, $user);
if (!$don) {
    flash_set('error', 'Don introuvable.');
    redirect('mon-compte.php');
}
if ($don['statut'] === 'en_attente') {
    redirect('paiement.php?don=' . $donId);
}

$moyen = $_SESSION['paiement_moyen'][$donId] ?? null;
$justePaye = $moyen !== null;
unset($_SESSION['paiement_moyen'][$donId]);

$pageTitle = 'Paiement effectué — Gouttes Rouges';
require __DIR__ . '/includes/header.php';
?>
<section class="section pay-section">
  <div class="container pay-wrap">
    <?php if ($justePaye): ?>
      <div class="pay-redirect" data-pay-redirect>
        <span class="pay-spinner" aria-hidden="true"></span>
        <p>Traitement du paiement en cours…</p>
      </div>
    <?php endif; ?>

    <div class="card pay-card pay-success">
      <span class="pay-check" aria-hidden="true">
        <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6"><path d="M20 6 9 17l-5-5"/></svg>
      </span>
      <h1>Paiement effectué</h1>
      <p class="lead">Merci <?= e($user['prenom']) ?> ! Votre don aide des filles à rester à l'école.</p>
      <dl class="pay-recap">
        <div><dt>Montant</dt><dd><?= e(number_format((float) $don['montant'], 0, ',', ' ')) ?> XOF</dd></div>
        <div><dt>Référence</dt><dd><?= e(paiement_reference($don)) ?></dd></div>
        <?php if ($moyen): ?><div><dt>Moyen de paiement</dt><dd><?= e($moyen) ?></dd></div><?php endif; ?>
        <div><dt>Date du don</dt><dd><?= e(format_date($don['created_at'])) ?></dd></div>
      </dl>
      <div class="hero-actions pay-actions">
        <a class="btn btn-dark" href="<?= e(url('mon-compte.php')) ?>">Voir mes dons</a>
        <a class="btn btn-light" href="<?= e(url('index.php')) ?>">Retour à l'accueil</a>
      </div>
    </div>
  </div>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
