<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2025 Chromared
?>

<?php function SaveLog($bdd, $page, $type, $comment){

    $user_id = $_SESSION['id'];
    $user_ip = $_SERVER['REMOTE_ADDR'];
    $username = $_SESSION['username'];
    $name = $_SESSION['firstname'] . ' ' . $_SESSION['lastname'];

    $insertLog = $bdd->prepare('INSERT INTO logs SET page = ?, user_id = ?, user_ip = ?, username = ?, user_name = ?, type = ?, comment = ?');
    $insertLog->execute(array($page, $user_id, $user_ip, $username, $name, $type, $comment));

}
