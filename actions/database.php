<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2025 Chromared
?>



<?php
    $host = '127.0.0.1';
    $dbname = 'bookfind';
    $username = 'bookfind';
    $password = 'bookfind';

    // Open a PDO connection to the local MySQL instance
    try {
        $bdd = new PDO('mysql:host=' . $host . ';dbname=' . $dbname . ';charset=utf8', $username, $password);
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo 'Connexion failed : ' . $e->getMessage();
    }