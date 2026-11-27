<?php
// Resolve the active theme token for the <html data-theme="..."> attribute.
// 0 = dark (default), 1 = light.
$theme = $_SESSION['theme'] ?? '0';

echo ($theme === '1') ? 'light' : 'dark';
