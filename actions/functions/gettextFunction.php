<?php
// Configure gettext for English source strings with an optional French catalog.
if (!function_exists('_')) {
    function _($message)
    {
        return function_exists('gettext') ? gettext($message) : $message;
    }
}

if (function_exists('bindtextdomain')) {
    $acceptedLanguage = strtolower($_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? '');
    $locale = ($_SESSION['locale'] ?? null) === 'fr_FR' || str_starts_with($acceptedLanguage, 'fr')
        ? 'fr_FR'
        : 'en_US';

    bindtextdomain('bookfind', dirname(__DIR__, 2) . '/locales');
    bind_textdomain_codeset('bookfind', 'UTF-8');
    textdomain('bookfind');

    if (defined('LC_MESSAGES')) {
        setlocale(LC_MESSAGES, $locale === 'fr_FR' ? ['fr_FR.UTF-8', 'fr_FR.utf8', 'French_France.1252'] : ['en_US.UTF-8', 'en_US.utf8', 'English_United States.1252']);
    } else {
        // Windows PHP builds commonly expose only LC_ALL rather than LC_MESSAGES.
        setlocale(LC_ALL, $locale === 'fr_FR' ? ['fr_FR.UTF-8', 'fr_FR.utf8', 'French_France.1252'] : ['en_US.UTF-8', 'en_US.utf8', 'English_United States.1252']);
    }
}
