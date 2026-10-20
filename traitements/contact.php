<?php
declare(strict_types=1);
require_once dirname(__DIR__) . '/includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !csrf_ok()) {
    flash_set('error', 'Session expirée. Merci de renvoyer le formulaire.');
    redirect('contact.php');
}

$nom = trim($_POST['nom'] ?? '');
$organisation = trim($_POST['organisation'] ?? '');
$email = trim($_POST['email'] ?? '');
$telephone = read_phone();
$objet = trim($_POST['objet'] ?? '');
$message = trim($_POST['message'] ?? '');

if ($nom === '' || $email === '' || $objet === '' || $message === '') {
    flash_set('error', 'Merci de remplir les champs obligatoires.');
    redirect('contact.php');
}
if (!valid_name($nom)) {
    flash_set('error', 'Le nom ne doit contenir que des lettres.');
    redirect('contact.php');
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    flash_set('error', 'Merci d\'indiquer un email valide.');
    redirect('contact.php');
}
if ($telephone === null) {
    flash_set('error', 'Le numéro de téléphone doit contenir uniquement des chiffres (6 à 14).');
    redirect('contact.php');
}

$estPartenariat = $objet === CONTACT_OBJET_PARTENARIAT;
$db = pdo();
if ($db && $estPartenariat) {
    $db->prepare(
        'INSERT INTO demandes_partenariat (organisation, responsable, email, telephone, type_partenariat, message, statut)
         VALUES (?, ?, ?, ?, ?, ?, ?)'
    )->execute([$organisation !== '' ? $organisation : $nom, $nom, $email, $telephone, null, $message, 'nouvelle']);
} elseif ($db) {
    $db->prepare('INSERT INTO messages (nom, email, telephone, objet, message, statut) VALUES (?, ?, ?, ?, ?, ?)')
        ->execute([$nom, $email, $telephone, $objet, $message, 'nouveau']);
} else {
    save_json($estPartenariat ? 'partenariats.json' : 'messages.json', compact('nom', 'organisation', 'email', 'telephone', 'objet', 'message'));
}

flash_set('success', 'Votre message a bien été envoyé.');
redirect('contact.php');
