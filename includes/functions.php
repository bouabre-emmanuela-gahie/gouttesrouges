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

function social_links(): string
{
    $facebook = '<svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M14 9h3V6h-3c-2.2 0-4 1.8-4 4v2H8v3h2v7h3v-7h3l1-3h-4V10c0-.6.4-1 1-1z"/></svg>';
    $instagram = '<svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M7 3h10a4 4 0 0 1 4 4v10a4 4 0 0 1-4 4H7a4 4 0 0 1-4-4V7a4 4 0 0 1 4-4zm10 2H7a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2zm-5 3.5A3.5 3.5 0 1 1 8.5 12 3.5 3.5 0 0 1 12 8.5zm4.8-.9a.9.9 0 1 1-.9.9.9.9 0 0 1 .9-.9z"/></svg>';
    return '<a href="' . e(SITE_FACEBOOK) . '" aria-label="Facebook" target="_blank" rel="noopener">' . $facebook . '</a>'
        . '<a href="' . e(SITE_INSTAGRAM) . '" aria-label="Instagram" target="_blank" rel="noopener">' . $instagram . '</a>';
}

function partners_grid(array $partenaires): string
{
    $html = '<div class="partners">';
    foreach ($partenaires as $partenaire) {
        $nom = (string) ($partenaire['nom'] ?? '');
        $logo = (string) ($partenaire['logo'] ?? '');
        $site = (string) ($partenaire['site_web'] ?? '');
        $inner = $logo !== '' && is_file(ROOT_PATH . '/assets/' . $logo)
            ? '<img src="' . e(asset($logo)) . '" alt="' . e($nom) . '" loading="lazy">'
            : e($nom);
        $html .= preg_match('#^https?://#', $site)
            ? '<a class="partner-slot" href="' . e($site) . '" target="_blank" rel="noopener" title="' . e($nom) . '">' . $inner . '</a>'
            : '<div class="partner-slot" title="' . e($nom) . '">' . $inner . '</div>';
    }
    return $html . '</div>';
}

/* —— Validation des champs —— */

const CONTACT_OBJET_PARTENARIAT = 'Proposition de partenariat';

const NAME_PATTERN = "[\\p{L}' \\-]+";

function phone_prefixes(): array
{
    return [
        '+225' => 'Côte d\'Ivoire', '+229' => 'Bénin', '+226' => 'Burkina Faso', '+237' => 'Cameroun',
        '+242' => 'Congo', '+243' => 'RD Congo', '+241' => 'Gabon', '+233' => 'Ghana',
        '+224' => 'Guinée', '+223' => 'Mali', '+227' => 'Niger', '+234' => 'Nigeria',
        '+221' => 'Sénégal', '+228' => 'Togo', '+212' => 'Maroc', '+213' => 'Algérie',
        '+216' => 'Tunisie', '+33' => 'France', '+32' => 'Belgique', '+41' => 'Suisse',
        '+44' => 'Royaume-Uni', '+49' => 'Allemagne', '+34' => 'Espagne', '+39' => 'Italie',
        '+1' => 'États-Unis / Canada',
    ];
}

/** Indicatif + numéro (chiffres uniquement), sous le nom de champ "telephone". */
function phone_field(string $id, string $label = 'Téléphone', bool $required = true, string $value = ''): string
{
    $prefix = '+225';
    $number = '';
    if (preg_match('/^(\+\d{1,4})\s?(\d+)$/', $value, $m) && isset(phone_prefixes()[$m[1]])) {
        [$prefix, $number] = [$m[1], $m[2]];
    }
    $options = '';
    foreach (phone_prefixes() as $code => $pays) {
        $options .= '<option value="' . e($code) . '"' . ($code === $prefix ? ' selected' : '') . '>' . e($pays . ' (' . $code . ')') . '</option>';
    }
    return '<div class="field"><label for="' . e($id) . '">' . e($label) . '</label>'
        . '<div class="phone-input">'
        . '<select name="telephone_prefixe" aria-label="Indicatif pays">' . $options . '</select>'
        . '<input id="' . e($id) . '" name="telephone" type="tel" inputmode="numeric" pattern="[0-9]{6,14}" maxlength="14"'
        . ' title="Chiffres uniquement (6 à 14 chiffres)" placeholder="0700000000" data-digits value="' . e($number) . '"' . ($required ? ' required' : '') . '>'
        . '</div></div>';
}

function name_attrs(): string
{
    return 'pattern="' . e(NAME_PATTERN) . '" title="Lettres uniquement" data-letters';
}

function valid_name(string $value): bool
{
    return (bool) preg_match('/^\p{L}[\p{L}\'’ \-]*$/u', $value) && mb_strlen($value) <= 80;
}

/** Retourne le numéro complet "+225 0700000000", '' si vide, null si invalide. */
function read_phone(): ?string
{
    $number = trim((string) ($_POST['telephone'] ?? ''));
    if ($number === '') {
        return '';
    }
    $prefix = (string) ($_POST['telephone_prefixe'] ?? '+225');
    if (!isset(phone_prefixes()[$prefix]) || !preg_match('/^\d{6,14}$/', $number)) {
        return null;
    }
    return $prefix . ' ' . $number;
}

/* —— Comptes utilisateurs (donateurs) —— */

function current_user(): ?array
{
    return $_SESSION['user'] ?? null;
}

function login_user(array $user): void
{
    session_regenerate_id(true);
    $_SESSION['user'] = [
        'id' => (int) $user['id'],
        'nom' => $user['nom'],
        'prenom' => $user['prenom'],
        'email' => $user['email'],
        'telephone' => $user['telephone'] ?? '',
    ];
}

/** Chemin interne sûr pour une redirection après connexion. */
function safe_redirect_target(?string $target, string $default = 'mon-compte.php'): string
{
    $target = (string) $target;
    return preg_match('#^[a-z0-9\-]+\.php(\#[a-z0-9\-]+)?$#', $target) ? $target : $default;
}

function don_produits(): array
{
    return ['Serviettes hygiéniques', 'Culottes menstruelles', 'Tampons', 'Savon et produits d\'hygiène', 'Sous-vêtements neufs'];
}

/* —— Paiement des dons financiers (mode démonstration) —— */

function paiement_moyens(): array
{
    return [
        'orange' => 'Orange Money',
        'mtn' => 'MTN Mobile Money',
        'moov' => 'Moov Money',
        'wave' => 'Wave',
        'carte' => 'Carte bancaire',
    ];
}

/** Don financier appartenant à l'utilisateur connecté, ou null. */
function don_du_donateur(int $donId, array $user): ?array
{
    return db_one(
        "SELECT d.*, t.libelle AS type_don
         FROM dons d
         JOIN donateurs don ON don.id = d.donateur_id
         JOIN types_dons t ON t.id = d.type_don_id
         WHERE d.id = ? AND don.email = ? AND t.libelle = 'financier'",
        [$donId, $user['email']]
    );
}

function paiement_reference(array $don): string
{
    return 'GR-' . date('Ymd', strtotime((string) $don['created_at']) ?: time()) . '-' . str_pad((string) $don['id'], 5, '0', STR_PAD_LEFT);
}
