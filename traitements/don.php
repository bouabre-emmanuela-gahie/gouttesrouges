<?php
declare(strict_types=1);

require_once dirname(__DIR__) . '/includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !csrf_ok()) {
    flash_set('error', 'Session expirée. Merci de renvoyer le formulaire.');
    redirect('nous-soutenir.php#don');
}

$user = current_user();
if (!$user) {
    flash_set('error', 'Connectez-vous pour faire un don.');
    redirect('connexion.php?redirect=' . urlencode('nous-soutenir.php#don'));
}

$type = ($_POST['type_don'] ?? '') === 'materiel' ? 'materiel' : 'financier';
$message = mb_substr(trim($_POST['message'] ?? ''), 0, 1000);
$montant = null;
$materiel = null;
$quantite = null;
$campagneId = null;

if ($type === 'financier') {
    $saisie = trim((string) ($_POST['montant_libre'] ?? ''));
    $saisie = $saisie !== '' ? $saisie : trim((string) ($_POST['montant'] ?? ''));
    if (!preg_match('/^\d{3,9}$/', $saisie) || (int) $saisie < 100) {
        flash_set('error', 'Le montant doit être un nombre d\'au moins 100 XOF.');
        redirect('nous-soutenir.php#don');
    }
    $montant = (int) $saisie;
} else {
    $materiel = trim($_POST['materiel'] ?? '');
    $quantite = (int) ($_POST['quantite'] ?? 0);
    if (!in_array($materiel, don_produits(), true) || $quantite < 1 || $quantite > 100000) {
        flash_set('error', 'Merci de choisir un produit et une quantité valide.');
        redirect('nous-soutenir.php#don-materiel');
    }
    $campagneId = ($_POST['campagne_id'] ?? '') !== '' ? (int) $_POST['campagne_id'] : null;
}

$row = [
    'nom' => $user['nom'],
    'prenom' => $user['prenom'],
    'email' => $user['email'],
    'telephone' => $user['telephone'],
    'type_don' => $type,
    'montant' => $montant,
    'materiel' => $materiel,
    'quantite' => $quantite,
    'campagne_id' => $campagneId,
    'message' => $message,
];

$db = pdo();
if ($db) {
    $db->beginTransaction();
    $existant = $db->prepare('SELECT id FROM donateurs WHERE email = ? ORDER BY id DESC LIMIT 1');
    $existant->execute([$user['email']]);
    $donateurId = (int) ($existant->fetchColumn() ?: 0);
    if (!$donateurId) {
        $db->prepare('INSERT INTO donateurs (nom, prenom, email, telephone) VALUES (?, ?, ?, ?)')
            ->execute([$user['nom'], $user['prenom'], $user['email'], $user['telephone']]);
        $donateurId = (int) $db->lastInsertId();
    }

    $typeRow = $db->prepare('SELECT id FROM types_dons WHERE libelle = ?');
    $typeRow->execute([$type]);
    $typeId = $typeRow->fetchColumn();
    if (!$typeId) {
        $db->prepare('INSERT INTO types_dons (libelle) VALUES (?)')->execute([$type]);
        $typeId = (int) $db->lastInsertId();
    }

    $db->prepare(
        'INSERT INTO dons (donateur_id, type_don_id, montant, quantite, materiel, campagne_id, message, statut)
         VALUES (?, ?, ?, ?, ?, ?, ?, ?)'
    )->execute([$donateurId, $typeId, $montant, $quantite, $materiel, $campagneId, $message, 'en_attente']);
    $db->commit();
} else {
    save_json('dons.json', $row);
}

flash_set('success', 'Merci ' . $user['prenom'] . ' ! Votre don a bien été enregistré. Retrouvez-le dans « Mon compte ».');
redirect('mon-compte.php');
