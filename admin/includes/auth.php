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
