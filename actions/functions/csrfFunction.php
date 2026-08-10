<?php
// CSRF helper for BookFind

if (!function_exists('csrf_token')) {
    function csrf_token() {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
}

if (!function_exists('csrf_field')) {
    function csrf_field() {
        return '<input type="hidden" name="csrf_token" value="' . csrf_token() . '">';
    }
}

if (!function_exists('csrf_verify')) {
    function csrf_verify() {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();
        if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'])) {
            http_response_code(403);
            die('Jeton CSRF invalide.');
        }
    }
}
