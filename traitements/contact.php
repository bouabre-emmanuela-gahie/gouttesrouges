<?php
declare(strict_types=1);
require_once dirname(__DIR__) . '/includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !csrf_ok()) {
    flash_set('error', 'Session expirée. Merci de renvoyer le formulaire.');
    redirect('contact.php');
}

$nom = trim($_POST['nom'] ?? '');
$email = trim($_POST['email'] ?? '');
$telephone = trim($_POST['telephone'] ?? '');
$objet = trim($_POST['objet'] ?? '');
$message = trim($_POST['message'] ?? '');

if ($nom === '' || $email === '' || $objet === '' || $message === '') {
    flash_set('error', 'Merci de remplir les champs obligatoires.');
    redirect('contact.php');
}

$row = compact('nom', 'email', 'telephone', 'objet', 'message');
$db = pdo();
if ($db) {
    $db->prepare('INSERT INTO messages (nom, email, telephone, objet, message, statut) VALUES (?, ?, ?, ?, ?, ?)')
        ->execute([$nom, $email, $telephone, $objet, $message, 'nouveau']);
} else {
    save_json('messages.json', $row);
}

flash_set('success', 'Votre message a bien été envoyé.');
redirect('contact.php');
