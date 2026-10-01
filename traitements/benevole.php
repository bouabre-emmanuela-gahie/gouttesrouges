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
$telephone = trim($_POST['telephone'] ?? '');
$ville = trim($_POST['ville'] ?? '');
$domaine = trim($_POST['domaine_interet'] ?? '');
$motivation = trim($_POST['motivation'] ?? '');

if ($nom === '' || $prenom === '' || $email === '' || $ville === '' || $motivation === '') {
    flash_set('error', 'Merci de remplir le formulaire bénévole.');
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
