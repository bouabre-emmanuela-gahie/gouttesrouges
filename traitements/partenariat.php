<?php
declare(strict_types=1);
require_once dirname(__DIR__) . '/includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !csrf_ok()) {
    flash_set('error', 'Session expirée. Merci de renvoyer le formulaire.');
    redirect('nous-soutenir.php#partenariat');
}

$organisation = trim($_POST['organisation'] ?? '');
$responsable = trim($_POST['responsable'] ?? '');
$email = trim($_POST['email'] ?? '');
$telephone = trim($_POST['telephone'] ?? '');
$type = trim($_POST['type_partenariat'] ?? '');
$message = trim($_POST['message'] ?? '');

if ($organisation === '' || $responsable === '' || $email === '' || $message === '') {
    flash_set('error', 'Merci de remplir la demande de partenariat.');
    redirect('nous-soutenir.php#partenariat');
}

$row = compact('organisation', 'responsable', 'email', 'telephone', 'type', 'message');
$db = pdo();
if ($db) {
    $db->prepare(
        'INSERT INTO demandes_partenariat (organisation, responsable, email, telephone, type_partenariat, message, statut)
         VALUES (?, ?, ?, ?, ?, ?, ?)'
    )->execute([$organisation, $responsable, $email, $telephone, $type, $message, 'nouvelle']);
} else {
    save_json('partenariats.json', $row);
}

flash_set('success', 'Votre demande de partenariat a bien été envoyée.');
redirect('nous-soutenir.php#partenariat');
