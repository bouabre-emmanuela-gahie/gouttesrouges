<?php
require_once __DIR__ . '/includes/functions.php';

unset($_SESSION['user']);
session_regenerate_id(true);
flash_set('success', 'Vous êtes déconnecté(e).');
redirect('index.php');
