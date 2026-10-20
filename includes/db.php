<?php
declare(strict_types=1);

function pdo(): ?PDO
{
    static $pdo = null;
    static $attempted = false;

    if ($attempted) {
        return $pdo;
    }

    $attempted = true;

    try {
        $pdo = new PDO(
            'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET,
            DB_USER,
            DB_PASS,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]
        );
    } catch (Throwable $e) {
        $pdo = null;
    }

    return $pdo;
}

function db_all(string $sql, array $params = []): array
{
    $db = pdo();
    if (!$db) {
        return [];
    }
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

function db_one(string $sql, array $params = []): ?array
{
    $rows = db_all($sql, $params);
    return $rows[0] ?? null;
}

function db_exec(string $sql, array $params = []): int
{
    $db = pdo();
    if (!$db) {
        return 0;
    }
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    return (int) $db->lastInsertId();
}

function db_count(string $table): int
{
    $db = pdo();
    if (!$db) {
        return 0;
    }
    $allowed = [
        'articles', 'campagnes', 'dons', 'messages', 'partenaires',
        'demandes_partenariat', 'visiteurs', 'newsletter', 'donateurs', 'utilisateurs',
    ];
    if (!in_array($table, $allowed, true)) {
        return 0;
    }
    return (int) $db->query("SELECT COUNT(*) FROM `$table`")->fetchColumn();
}
