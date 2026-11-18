<?php

declare(strict_types=1);

// Direktori utama aplikasi
define('BASE_PATH', dirname(__DIR__));

// Direktori penyimpanan data
define('DATA_PATH', BASE_PATH . '/data');

// URL dasar aplikasi
$scriptName = str_replace(
    '\\',
    '/',
    $_SERVER['SCRIPT_NAME'] ?? ''
);

$baseUrl = rtrim(dirname($scriptName), '/');

// Jika halaman berada di folder admin/member/catalog
$lastFolder = basename($baseUrl);

if (in_array($lastFolder, ['admin', 'member', 'catalog'], true)) {
    $baseUrl = rtrim(dirname($baseUrl), '/');
}

if ($baseUrl === '.' || $baseUrl === '/') {
    $baseUrl = '';
}

define('BASE_URL', $baseUrl);

// Session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Pastikan folder data tersedia
if (!is_dir(DATA_PATH)) {
    mkdir(DATA_PATH, 0755, true);
}

// Autoload Class
spl_autoload_register(function (string $class): void {
    $prefix = 'App\\';
    $baseDirectory = BASE_PATH . '/src/';

    $prefixLength = strlen($prefix);

    if (strncmp($prefix, $class, $prefixLength) !== 0) {
        return;
    }

    $relativeClass = substr($class, $prefixLength);

    $file = $baseDirectory
          . str_replace('\\', DIRECTORY_SEPARATOR, $relativeClass)
          . '.php';

    if (file_exists($file)) {
        require_once $file;
    }
});

// Helper keamanan output
if (!function_exists('e')) {
    function e(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }
}

// Helper URL
if (!function_exists('app_url')) {
    function app_url(string $path = ''): string
    {
        return BASE_URL . '/' . ltrim($path, '/');
    }
}

// Helper redirect
if (!function_exists('redirect')) {
    function redirect(string $path): never
    {
        $path = ltrim(str_replace('\\', '/', $path), '/');

        header('Location: /' . $path);
        exit;
    }
}
