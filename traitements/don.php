<?php
declare(strict_types=1);

require_once dirname(__DIR__) . '/includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !csrf_ok()) {
    flash_set('error', 'Session expirée. Merci de renvoyer le formulaire.');
    redirect('nous-soutenir.php#don');
}

$type = $_POST['type_don'] ?? 'financier';
$nom = trim($_POST['nom'] ?? '');
$prenom = trim($_POST['prenom'] ?? '');
$email = trim($_POST['email'] ?? '');
$telephone = trim($_POST['telephone'] ?? '');
$message = trim($_POST['message'] ?? '');
$campagneId = $_POST['campagne_id'] !== '' ? (int) $_POST['campagne_id'] : null;
$montant = (int) ($_POST['montant_libre'] ?: ($_POST['montant'] ?? 0));
$materiel = trim($_POST['materiel'] ?? '');
$quantite = (int) ($_POST['quantite'] ?? 0);

if ($nom === '' || $prenom === '' || $email === '' || $telephone === '') {
    flash_set('error', 'Merci de renseigner votre identité et vos coordonnées.');
    redirect('nous-soutenir.php#don');
}

$row = [
    'nom' => $nom,
    'prenom' => $prenom,
    'email' => $email,
    'telephone' => $telephone,
    'type_don' => $type,
    'montant' => $type === 'financier' ? $montant : null,
    'materiel' => $type === 'materiel' ? $materiel : null,
    'quantite' => $type === 'materiel' ? $quantite : null,
    'campagne_id' => $campagneId,
    'message' => $message,
];

$db = pdo();
if ($db) {
    $db->beginTransaction();
    $stmt = $db->prepare('INSERT INTO donateurs (nom, prenom, email, telephone) VALUES (?, ?, ?, ?)');
    $stmt->execute([$nom, $prenom, $email, $telephone]);
    $donateurId = (int) $db->lastInsertId();

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
    )->execute([
        $donateurId,
        $typeId,
        $row['montant'],
        $row['quantite'],
        $row['materiel'],
        $campagneId,
        $message,
        'en_attente',
    ]);
    $db->commit();
} else {
    save_json('dons.json', $row);
}

flash_set('success', 'Merci. Votre don a bien été enregistré. L\'équipe vous recontactera si besoin.');
redirect('nous-soutenir.php#don');
