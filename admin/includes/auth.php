<?php
declare(strict_types=1);

require_once dirname(__DIR__, 2) . '/includes/functions.php';

function admin_user(): ?array
{
    return $_SESSION['admin'] ?? null;
}

function require_admin(): void
{
    if (!admin_user()) {
        header('Location: ' . url('admin/login.php'));
        exit;
    }
}

function admin_nav(string $file): string
{
    return basename($_SERVER['SCRIPT_NAME'] ?? '') === $file ? ' is-active' : '';
}

/**
 * Enregistre une image envoyée depuis un formulaire admin dans assets/img/<dossier>/.
 * Retourne le chemin utilisable avec asset() (ex. "img/articles/abc.jpg"),
 * null si aucun fichier, ou lève une RuntimeException si le fichier est refusé.
 */
function admin_upload_image(string $field, string $dossier): ?string
{
    $file = $_FILES[$field] ?? null;
    if (!$file || ($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
        return null;
    }
    if ($file['error'] !== UPLOAD_ERR_OK || $file['size'] > 5 * 1024 * 1024) {
        throw new RuntimeException('Image refusée : 5 Mo maximum.');
    }
    $types = [IMAGETYPE_JPEG => 'jpg', IMAGETYPE_PNG => 'png', IMAGETYPE_WEBP => 'webp'];
    $info = @getimagesize($file['tmp_name']);
    if (!$info || !isset($types[$info[2]])) {
        throw new RuntimeException('Image refusée : formats acceptés JPG, PNG ou WEBP.');
    }
    $dir = ROOT_PATH . '/assets/img/' . $dossier;
    if (!is_dir($dir) && !mkdir($dir, 0775, true)) {
        throw new RuntimeException('Impossible de créer le dossier des images.');
    }
    $name = date('Ymd-His') . '-' . bin2hex(random_bytes(4)) . '.' . $types[$info[2]];
    if (!move_uploaded_file($file['tmp_name'], $dir . '/' . $name)) {
        throw new RuntimeException('Échec de l\'enregistrement de l\'image.');
    }
    return 'img/' . $dossier . '/' . $name;
}

function slugify(string $text): string
{
    $text = strtr(mb_strtolower($text), [
        'à' => 'a', 'â' => 'a', 'ä' => 'a', 'á' => 'a', 'ã' => 'a', 'ç' => 'c',
        'é' => 'e', 'è' => 'e', 'ê' => 'e', 'ë' => 'e', 'î' => 'i', 'ï' => 'i', 'í' => 'i',
        'ô' => 'o', 'ö' => 'o', 'ó' => 'o', 'õ' => 'o', 'ù' => 'u', 'û' => 'u', 'ü' => 'u', 'ú' => 'u',
        'ÿ' => 'y', 'ñ' => 'n', 'œ' => 'oe', 'æ' => 'ae', '’' => '-', "'" => '-',
    ]);
    $text = strtolower(trim(preg_replace('/[^A-Za-z0-9]+/', '-', $text), '-'));
    return $text !== '' ? $text : 'article';
}

/** Texte simple → paragraphes HTML ; le HTML déjà saisi est conservé tel quel. */
function text_to_html(string $text): string
{
    $text = trim($text);
    if ($text === '' || preg_match('/<(p|h[1-6]|ul|ol|div|blockquote|br)\b/i', $text)) {
        return $text;
    }
    $paragraphs = preg_split('/\R{2,}/', $text);
    return implode('', array_map(fn ($p) => '<p>' . nl2br(e(trim($p))) . '</p>', $paragraphs));
}
