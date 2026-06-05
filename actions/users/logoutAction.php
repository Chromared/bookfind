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

$deleteCookies = $bdd->prepare('DELETE FROM cookies WHERE user_id = ?');
$deleteCookies->execute(array($_SESSION['id']));

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

SaveLog($bdd, $_SERVER['REQUEST_URI'], 'Déconnexion', 'Aucun commentaire.');

header('Location: ../../login.php');
