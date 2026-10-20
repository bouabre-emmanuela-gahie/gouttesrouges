<?php
declare(strict_types=1);
require_once dirname(__DIR__) . '/includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !csrf_ok()) {
    flash_set('error', 'Session expirée. Merci de renvoyer le formulaire.');
    redirect('nous-soutenir.php#benevolat');
}

$nom = trim($_POST['nom'] ?? '');
$prenom = trim($_POST['prenom'] ?? '');
$email = trim($_POST['email'] ?? '');
$telephone = read_phone();
$ville = trim($_POST['ville'] ?? '');
$domaine = trim($_POST['domaine_interet'] ?? '');
$motivation = trim($_POST['motivation'] ?? '');

if ($nom === '' || $prenom === '' || $email === '' || $ville === '' || $motivation === '') {
    flash_set('error', 'Merci de remplir le formulaire bénévole.');
    redirect('nous-soutenir.php#benevolat');
}
if (!valid_name($nom) || !valid_name($prenom) || !valid_name($ville)) {
    flash_set('error', 'Le nom, le prénom et la ville ne doivent contenir que des lettres.');
    redirect('nous-soutenir.php#benevolat');
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    flash_set('error', 'Merci d\'indiquer un email valide.');
    redirect('nous-soutenir.php#benevolat');
}
if ($telephone === null || $telephone === '') {
    flash_set('error', 'Le numéro de téléphone doit contenir uniquement des chiffres (6 à 14).');
    redirect('nous-soutenir.php#benevolat');
}

$row = compact('nom', 'prenom', 'email', 'telephone', 'ville', 'domaine', 'motivation');
$db = pdo();
if ($db) {
    $db->prepare(
        'INSERT INTO visiteurs (nom, prenom, email, telephone, ville, domaine_interet, motivation)
         VALUES (?, ?, ?, ?, ?, ?, ?)'
    )->execute([$nom, $prenom, $email, $telephone, $ville, $domaine, $motivation]);
} else {
    save_json('benevoles.json', $row);
}

flash_set('success', 'Votre candidature bénévole a bien été transmise.');
redirect('nous-soutenir.php#benevolat');
