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
if ($don['statut'] !== 'en_attente') {
    redirect('paiement-effectue.php?don=' . $donId);
}

$moyens = paiement_moyens();
$error = '';
$moyen = 'orange';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $moyen = (string) ($_POST['moyen'] ?? '');
    if (!csrf_ok()) {
        $error = 'Session expirée. Merci de réessayer.';
    } elseif (!isset($moyens[$moyen])) {
        $error = 'Merci de choisir un moyen de paiement.';
    } elseif ($moyen === 'carte') {
        $carte = preg_replace('/\s+/', '', (string) ($_POST['carte_numero'] ?? ''));
        if (!preg_match('/^\d{16}$/', $carte)
            || !preg_match('/^(0[1-9]|1[0-2])\/\d{2}$/', (string) ($_POST['carte_expiration'] ?? ''))
            || !preg_match('/^\d{3}$/', (string) ($_POST['carte_cvv'] ?? ''))) {
            $error = 'Coordonnées de carte invalides (16 chiffres, date MM/AA, code à 3 chiffres).';
        }
    } elseif (read_phone() === null || read_phone() === '') {
        $error = 'Le numéro de paiement doit contenir uniquement des chiffres (6 à 14).';
    }

    if ($error === '') {
        db_exec("UPDATE dons SET statut = 'recu' WHERE id = ? AND statut = 'en_attente'", [$donId]);
        $_SESSION['paiement_moyen'][$donId] = $moyens[$moyen];
        redirect('paiement-effectue.php?don=' . $donId);
    }
}

$montant = number_format((float) $don['montant'], 0, ',', ' ') . ' XOF';
$pageTitle = 'Paiement sécurisé — Gouttes Rouges';
require __DIR__ . '/includes/header.php';
?>
<section class="section pay-section">
  <div class="container pay-wrap">
    <?php if ($_SERVER['REQUEST_METHOD'] !== 'POST'): ?>
      <div class="pay-redirect" data-pay-redirect>
        <span class="pay-spinner" aria-hidden="true"></span>
        <p>Redirection vers la plateforme de paiement sécurisé…</p>
      </div>
    <?php endif; ?>

    <form class="card pay-card" method="post" data-pay-form>
      <div class="pay-head">
        <span class="pay-lock" aria-hidden="true">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="4" y="11" width="16" height="10" rx="2"/><path d="M8 11V7a4 4 0 0 1 8 0v4"/></svg>
        </span>
        <div>
          <strong>Paiement sécurisé</strong>
          <small>Bénéficiaire : association Gouttes Rouges</small>
        </div>
      </div>

      <div class="pay-amount">
        <span>Montant du don</span>
        <strong><?= e($montant) ?></strong>
        <small>Référence <?= e(paiement_reference($don)) ?></small>
      </div>

      <?php if ($error): ?><div class="flash flash-error"><?= e($error) ?></div><?php endif; ?>
      <?= csrf_field() ?>

      <fieldset class="pay-methods">
        <legend>Moyen de paiement</legend>
        <?php foreach ($moyens as $code => $libelle): ?>
          <label class="pay-method">
            <input type="radio" name="moyen" value="<?= e($code) ?>" <?= $moyen === $code ? 'checked' : '' ?> data-pay-method>
            <span><?= e($libelle) ?></span>
          </label>
        <?php endforeach; ?>
      </fieldset>

      <div data-pay-panel="mobile">
        <?= phone_field('pay_tel', 'Numéro du compte mobile', false, (string) ($user['telephone'] ?? '')) ?>
      </div>
      <div data-pay-panel="carte" hidden>
        <div class="field"><label for="carte_numero">Numéro de carte</label><input id="carte_numero" name="carte_numero" inputmode="numeric" maxlength="19" placeholder="0000 0000 0000 0000" autocomplete="cc-number"></div>
        <div class="grid-2">
          <div class="field"><label for="carte_expiration">Expiration (MM/AA)</label><input id="carte_expiration" name="carte_expiration" maxlength="5" placeholder="MM/AA" autocomplete="cc-exp"></div>
          <div class="field"><label for="carte_cvv">Code de sécurité</label><input id="carte_cvv" name="carte_cvv" inputmode="numeric" maxlength="3" placeholder="123" autocomplete="cc-csc" data-digits></div>
        </div>
      </div>

      <button class="btn btn-dark pay-submit" type="submit">Payer <?= e($montant) ?></button>
      <p class="pay-demo">Mode démonstration : aucun débit réel n'est effectué.</p>
      <p class="pay-cancel"><a href="<?= e(url('mon-compte.php')) ?>">Annuler et revenir à mon compte</a></p>
    </form>
  </div>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
