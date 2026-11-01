<?php
//This file belongs to the BookFind project.
//
//BookFind is distributed under the terms of the GNU Affero General Public License v3.0.
//
//Copyright (C) 2025 Chromared
?>



<?php require '../database.php';
require '../functions/logFunction.php';
require_once __DIR__ . '/../functions/sessionInit.php';

$deleteCookies = $db->prepare('DELETE FROM cookies WHERE user_id = ?');
$deleteCookies->execute(array($_SESSION['id']));

SaveLog($db, $_SERVER['REQUEST_URI'], 'Logout', 'No comment.');

$_SESSION = [];
session_destroy();
setcookie(
    "auth_token",
    "",
    [
        "expires" => time() - 3600,
        "path" => "/",
        "secure" => true,
        "httponly" => true,
        "samesite" => "Strict"
    ]
);

header('Location: ../../index.php');
