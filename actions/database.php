<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the GNU Affero General Public License v3.0.
//
//Copyright (C) 2025 Chromared
?>



<?php
    $host = '';
    $dbname = '';
    $username = '';
    $password = '';

    $db_error_message = null;

    if(!empty($host) AND !empty($username)){
    
    try {
        $db = new PDO('mysql:host=' . $host . ';dbname=' . $dbname . ';charset=utf8', $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        $db = null;
        $db_error_message = 'Unable to connect to the database.';
    }}