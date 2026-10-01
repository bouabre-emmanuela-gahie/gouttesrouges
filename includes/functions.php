<?php
declare(strict_types=1);

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/data.php';

function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function url(string $path = ''): string
{
    $path = ltrim($path, '/');
    $base = BASE_URL;
    if ($path === '') {
        return $base === '' ? '/' : $base . '/';
    }
    return ($base === '' ? '' : $base) . '/' . $path;
}

function asset(string $path): string
{
    return url('assets/' . ltrim($path, '/'));
}

function current_script(): string
{
    return basename($_SERVER['SCRIPT_NAME'] ?? '');
}

function is_active(string $page): string
{
    return current_script() === $page ? ' is-active' : '';
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(16));
    }
    return $_SESSION['csrf'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="csrf" value="' . e(csrf_token()) . '">';
}

function csrf_ok(): bool
{
    return isset($_POST['csrf'], $_SESSION['csrf'])
        && hash_equals($_SESSION['csrf'], (string) $_POST['csrf']);
}

function flash_set(string $type, string $message): void
{
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function flash_get(): ?array
{
    $flash = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    return $flash;
}

function redirect(string $path): void
{
    header('Location: ' . url($path));
    exit;
}

function save_json(string $file, array $row): void
{
    $path = DATA_PATH . '/' . $file;
    $items = [];
    if (is_file($path)) {
        $decoded = json_decode((string) file_get_contents($path), true);
        if (is_array($decoded)) {
            $items = $decoded;
        }
    }
    $row['created_at'] = date('Y-m-d H:i:s');
    $items[] = $row;
    file_put_contents($path, json_encode($items, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

function get_articles(?int $limit = null): array
{
    $rows = db_all(
        "SELECT a.*, c.nom AS categorie
         FROM articles a
         LEFT JOIN categories c ON c.id = a.categorie_id
         WHERE a.statut = 'publie'
         ORDER BY a.date_publication DESC" . ($limit ? " LIMIT $limit" : '')
    );
    return $rows ?: array_slice(fallback_articles(), 0, $limit ?? 100);
}

function get_article(string $slug): ?array
{
    $row = db_one(
        "SELECT a.*, c.nom AS categorie
         FROM articles a
         LEFT JOIN categories c ON c.id = a.categorie_id
         WHERE a.slug = ? AND a.statut = 'publie'",
        [$slug]
    );
    if ($row) {
        return $row;
    }
    foreach (fallback_articles() as $article) {
        if ($article['slug'] === $slug) {
            return $article;
        }
    }
    return null;
}

function get_campagnes(?int $limit = null): array
{
    $rows = db_all(
        "SELECT * FROM campagnes WHERE statut = 'publie' ORDER BY date_debut DESC" . ($limit ? " LIMIT $limit" : '')
    );
    return $rows ?: array_slice(fallback_campagnes(), 0, $limit ?? 100);
}

function get_campagne(string $slug): ?array
{
    $row = db_one("SELECT * FROM campagnes WHERE slug = ? AND statut = 'publie'", [$slug]);
    if ($row) {
        return $row;
    }
    foreach (fallback_campagnes() as $campagne) {
        if ($campagne['slug'] === $slug) {
            return $campagne;
        }
    }
    return null;
}

function get_partenaires(): array
{
    return db_all("SELECT * FROM partenaires ORDER BY nom ASC") ?: fallback_partenaires();
}

function get_temoignages(): array
{
    $rows = db_all("SELECT * FROM temoignages ORDER BY id DESC");
    return $rows ?: fallback_temoignages();
}

function get_equipe(): array
{
    $rows = db_all("SELECT * FROM equipe ORDER BY ordre ASC");
    return $rows ?: fallback_equipe();
}

function get_chiffres(): array
{
    $rows = db_all("SELECT * FROM chiffres_cles ORDER BY ordre ASC");
    return $rows ?: fallback_chiffres();
}

function get_faq(): array
{
    $rows = db_all("SELECT * FROM faq ORDER BY ordre ASC");
    return $rows ?: fallback_faq();
}

function get_glossaire(): array
{
    $rows = db_all("SELECT * FROM glossaire ORDER BY terme ASC");
    return $rows ?: fallback_glossaire();
}

function get_supports(): array
{
    $rows = db_all("SELECT * FROM supports_educatifs ORDER BY date_publication DESC");
    return $rows ?: fallback_supports();
}

function get_programmes(): array
{
    return fallback_programmes();
}

function get_domaines(): array
{
    return fallback_domaines();
}

function format_date(?string $date): string
{
    if (!$date) {
        return '';
    }
    $ts = strtotime($date);
    if (!$ts) {
        return $date;
    }
    $months = [
        1 => 'janvier', 2 => 'février', 3 => 'mars', 4 => 'avril',
        5 => 'mai', 6 => 'juin', 7 => 'juillet', 8 => 'août',
        9 => 'septembre', 10 => 'octobre', 11 => 'novembre', 12 => 'décembre',
    ];
    return (int) date('j', $ts) . ' ' . $months[(int) date('n', $ts)] . ' ' . date('Y', $ts);
}

function excerpt(string $text, int $length = 160): string
{
    $text = trim(strip_tags($text));
    if (mb_strlen($text) <= $length) {
        return $text;
    }
    return mb_substr($text, 0, $length) . '…';
}
