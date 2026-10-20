<?php
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// define('DB_HOST', '127.0.0.1');
// define('DB_NAME', 'gouttes_rouges');
// define('DB_USER', 'root');
// define('DB_PASS', '');
// define('DB_CHARSET', 'utf8mb4');
define('DB_HOST', 'mysql-gouttes-rouges.alwaysdata.net');
define('DB_NAME', 'gouttes-rouges_gouttes');
define('DB_USER', 'gouttes-rouges_admin');
define('DB_PASS', 'Simigbe2312@@@');
define('DB_CHARSET', 'utf8mb4');

define('SITE_NAME', 'Gouttes Rouges');
define('SITE_EMAIL', 'gouttesrouges@gmail.com');
define('SITE_PHONE', '+225 07 88 68 13 27');
define('SITE_ADDRESS', 'Cocody, Abidjan, Côte d\'Ivoire');
define('SITE_TAGLINE', 'Pour une santé menstruelle digne et accessible.');
define('SITE_FACEBOOK', 'https://www.facebook.com/profile.php?id=100064541510692');
define('SITE_INSTAGRAM', 'https://www.instagram.com/gouttesrouges/');

$rootFs = dirname(__DIR__);
$docRoot = isset($_SERVER['DOCUMENT_ROOT']) ? realpath($_SERVER['DOCUMENT_ROOT']) : false;
$base = '';
if ($docRoot) {
    $rootReal = realpath($rootFs) ?: $rootFs;
    $base = str_replace('\\', '/', substr($rootReal, strlen($docRoot)));
}
define('BASE_URL', $base === '' || $base === '/' ? '' : rtrim($base, '/'));
define('ROOT_PATH', $rootFs);
define('DATA_PATH', $rootFs . '/data');

if (!is_dir(DATA_PATH)) {
    @mkdir(DATA_PATH, 0775, true);
}
