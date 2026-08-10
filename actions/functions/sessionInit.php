<?php
// Central session initialization and security headers for BookFind
// Sets secure cookie params, starts session, sends common security headers,
// and enforces CSRF verification on POST requests.

// Configure secure session cookie parameters
$secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https');
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => '',
    'secure' => $secure,
    'httponly' => true,
    'samesite' => 'Lax'
]);
ini_set('session.use_strict_mode', 1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// Security headers
if (!headers_sent()) {
    header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
    header('X-Frame-Options: SAMEORIGIN');
    header('X-Content-Type-Options: nosniff');
    header('Referrer-Policy: strict-origin-when-cross-origin');
    header('Permissions-Policy: geolocation=(), microphone=(), camera=()');
    // Générer un nonce CSP pour autoriser l'exécution des scripts inline de confiance
    $csp_nonce = bin2hex(random_bytes(16));
    // stocker le nonce en session pour que les vues puissent l'utiliser
    $_SESSION['csp_nonce'] = $csp_nonce;
    $script_src = "'self' 'nonce-{$csp_nonce}' https://code.jquery.com https://cdn.jsdelivr.net https://cdn.jsdelivr.net/npm";
    $style_src = "'self' 'unsafe-inline' https://cdn.jsdelivr.net https://code.jquery.com";
    $connect_src = "'self' https://cdn.jsdelivr.net https://code.jquery.com";
    header("Content-Security-Policy: default-src 'self'; script-src {$script_src}; style-src {$style_src}; img-src 'self' data:; font-src https://cdn.jsdelivr.net; connect-src {$connect_src};");
}

// Enforce CSRF for POST requests globally (pages that include this file)
// Charger les helpers CSRF (fonctions disponibles pour les formulaires)
require_once __DIR__ . '/csrfFunction.php';

// Enforce CSRF for POST requests globally (pages that include this file)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // csrf_verify() will die(403) on failure
    csrf_verify();
}
