<?php

$rootPath = realpath(__DIR__ . '/..');
if ($rootPath === false) {
    throw new RuntimeException('Unable to resolve the application root path.');
}

if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', $rootPath);
}

$documentRoot = realpath($_SERVER['DOCUMENT_ROOT'] ?? '');
if ($documentRoot === false) {
    $baseUrl = '';
} else {
    $normalizedRoot = rtrim(str_replace('\\', '/', ROOT_PATH), '/');
    $normalizedDocumentRoot = rtrim(str_replace('\\', '/', $documentRoot), '/');
    $rootPrefix = $normalizedDocumentRoot === '' ? '/' : $normalizedDocumentRoot . '/';
    $normalizedRootForComparison = strtolower($normalizedRoot);
    $normalizedPrefixForComparison = strtolower($rootPrefix);

    if ($normalizedRootForComparison === strtolower($normalizedDocumentRoot)) {
        $baseUrl = '';
    } elseif (strpos($normalizedRootForComparison, $normalizedPrefixForComparison) === 0) {
        $baseUrl = '/' . trim(substr($normalizedRoot, strlen($rootPrefix)), '/');
    } else {
        $baseUrl = '';
    }
}

if (!defined('BASE_URL')) {
    define('BASE_URL', $baseUrl);
}

if (!function_exists('url')) {
    function url(string $path = ''): string
    {
        return BASE_URL . '/' . ltrim($path, '/');
    }
}

if (!function_exists('asset')) {
    function asset(string $path): string
    {
        $relativePath = ltrim($path, '/');
        $filePath = ROOT_PATH . DIRECTORY_SEPARATOR
            . str_replace('/', DIRECTORY_SEPARATOR, $relativePath);
        $version = is_file($filePath) ? @filemtime($filePath) : false;

        return url($relativePath) . '?v=' . ($version === false ? '1' : (string)$version);
    }
}
