<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2024 Chromared
?>



<?php require '../database.php';
    require '../functions/logFunction.php';
session_start();

    SaveLog($bdd, $_SERVER['REQUEST_URI'], 'Déconnexion', 'Aucun commentaire.');

$_SESSION = [];
session_destroy();
header('Location: ../../login.php');