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
    // Generate a CSP nonce to allow trusted inline scripts
    $csp_nonce = bin2hex(random_bytes(16));
    // Store the nonce in session so templates/views can embed it in script tags
    $_SESSION['csp_nonce'] = $csp_nonce;
    $script_src = "'self' 'nonce-{$csp_nonce}' https://code.jquery.com https://cdn.jsdelivr.net https://cdn.jsdelivr.net/npm";
    $style_src = "'self' 'unsafe-inline' https://cdn.jsdelivr.net https://code.jquery.com";
    $connect_src = "'self' https://cdn.jsdelivr.net https://code.jquery.com";
    header("Content-Security-Policy: default-src 'self'; script-src {$script_src}; style-src {$style_src}; img-src 'self' data:; font-src https://cdn.jsdelivr.net; connect-src {$connect_src};");
}

// Load CSRF helper functions (used to verify tokens in forms)
require_once __DIR__ . '/csrfFunction.php';

// Verify CSRF token for all incoming POST requests.
// Note: csrf_verify() will terminate with a 403 response on failure.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();
}
