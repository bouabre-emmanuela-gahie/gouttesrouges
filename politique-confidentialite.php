<?php
$pageTitle = 'Politique de confidentialité — Gouttes Rouges';
require __DIR__ . '/includes/header.php';
?>
<section class="section">
  <div class="container prose">
    <h1>Politique de confidentialité</h1>
    <p>Gouttes Rouges collecte uniquement les données nécessaires au traitement de vos demandes : identité, coordonnées, messages, dons, candidatures bénévoles et partenariats.</p>
    <p>Ces informations sont enregistrées dans une base MySQL sécurisée, accessibles à l'administrateur, et ne sont pas vendues à des tiers.</p>
    <p>Vous pouvez demander l'accès, la rectification ou la suppression de vos données en écrivant à <?= e(SITE_EMAIL) ?>.</p>
    <p>Les cookies éventuellement utilisés se limitent au fonctionnement du site (session d'administration, jeton de formulaire).</p>
  </div>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
