<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2025 Chromared
?>



<?php require '../database.php';
require '../functions/logFunction.php';
session_start();

SaveLog($bdd, $_SERVER['REQUEST_URI'], 'Déconnexion', 'Aucun commentaire.');

$_SESSION = [];
session_destroy();
setcookie(
    "auth_token",
    "",
    [
        "expires" => time() - 3600, // date passée → suppression
        "path" => "/",
        "secure" => true,
        "httponly" => true,
        "samesite" => "Strict"
    ]
);
header('Location: ../../login.php');
