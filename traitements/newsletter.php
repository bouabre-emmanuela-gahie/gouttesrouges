<?php
declare(strict_types=1);
require_once dirname(__DIR__) . '/includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !csrf_ok()) {
    flash_set('error', 'Session expirée.');
    redirect('contact.php');
}

$email = trim($_POST['email'] ?? '');
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    flash_set('error', 'Merci d\'indiquer un email valide.');
    redirect('contact.php');
}

$db = pdo();
if ($db) {
    try {
        $db->prepare('INSERT INTO newsletter (email, statut) VALUES (?, ?)')->execute([$email, 'actif']);
    } catch (Throwable $e) {
        flash_set('error', 'Cet email est déjà inscrit, ou l\'inscription a échoué.');
        redirect('contact.php');
    }
} else {
    save_json('newsletter.json', ['email' => $email]);
}

flash_set('success', 'Inscription à la newsletter confirmée.');
redirect('contact.php');
