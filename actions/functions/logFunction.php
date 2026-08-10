<?php
//This file belongs to the BookFind project.
//
//BookFind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2025 Chromared
?>

<?php function sanitize_log_comment($html){
    // Allow only <a> tags with a secure href (http(s) or relative path)
    if (empty($html)) return '';

    $doc = new DOMDocument();
    libxml_use_internal_errors(true);
    // load as an HTML fragment
    $doc->loadHTML('<?xml encoding="utf-8" ?><div>' . $html . '</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
    libxml_clear_errors();

    $allowed = [];
    $div = $doc->getElementsByTagName('div')->item(0);
    if (!$div) return htmlspecialchars($html, ENT_QUOTES);

    // Iterate recursively and reconstruct a safe fragment
    $safeFragments = [];

    foreach ($div->childNodes as $node) {
        if ($node->nodeType === XML_TEXT_NODE) {
            $safeFragments[] = htmlspecialchars($node->nodeValue, ENT_QUOTES);
        } elseif ($node->nodeType === XML_ELEMENT_NODE && strtolower($node->nodeName) === 'a') {
            $href = '';
            if ($node instanceof DOMElement) {
                $href = $node->getAttribute('href');
            }
            $text = '';
            foreach ($node->childNodes as $c) {
                if ($c->nodeType === XML_TEXT_NODE) $text .= $c->nodeValue;
            }

            // Valider le href
            $valid = false;
            if ($href === '') {
                $valid = false;
            } else {
                $parts = parse_url($href);
                if ($parts === false) {
                    $valid = false;
                } else {
                    if (!isset($parts['scheme'])) {
                        // relative path -> allowed
                        $valid = true;
                    } else {
                        $scheme = strtolower($parts['scheme']);
                        if (in_array($scheme, ['http', 'https'])) $valid = true;
                    }
                }
            }

            if ($valid) {
                $safeHref = htmlspecialchars($href, ENT_QUOTES);
                $safeText = htmlspecialchars($text, ENT_QUOTES);
                $safeFragments[] = '<a href="' . $safeHref . '" rel="noopener noreferrer">' . $safeText . '</a>';
            } else {
                // if href is invalid, display only the text
                $safeFragments[] = htmlspecialchars($text, ENT_QUOTES);
            }
        } else {
            // for any other element, safely extract the text
            $safeFragments[] = htmlspecialchars($node->textContent ?? '', ENT_QUOTES);
        }
    }

    return implode('', $safeFragments);
}

function SaveLog($bdd, $page, $type, $comment){

    $user_id = $_SESSION['id'] ?? null;
    $user_ip = $_SERVER['REMOTE_ADDR'] ?? '';
    $username = $_SESSION['username'] ?? '';
    $name = ($_SESSION['firstname'] ?? '') . ' ' . ($_SESSION['lastname'] ?? '');

    // Sanitize the comment to allow only safe links
    $safe_comment = sanitize_log_comment($comment ?? '');
    $safe_page = htmlspecialchars($page ?? '', ENT_QUOTES);
    $safe_type = htmlspecialchars($type ?? '', ENT_QUOTES);
    $safe_username = htmlspecialchars($username ?? '', ENT_QUOTES);
    $safe_name = htmlspecialchars($name ?? '', ENT_QUOTES);

    $insertLog = $bdd->prepare('INSERT INTO logs SET page = ?, user_id = ?, user_ip = ?, username = ?, user_name = ?, type = ?, comment = ?');
    $insertLog->execute(array($safe_page, $user_id, $user_ip, $safe_username, $safe_name, $safe_type, $safe_comment));

}
