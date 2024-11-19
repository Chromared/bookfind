<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2024 Chromared
?>

<?php function SaveLog($bdd, $page, $type, $comment){

    $userSystem = $_SERVER['HTTP_USER_AGENT'];

    $user_id = $_SESSION['id'];
    $user_card = $_SESSION['card'];
    $name = $_SESSION['firstname'] . ' ' . $_SESSION['lastname'];

    $insertLog = $bdd->prepare('INSERT INTO log SET page = ?, user_id = ?, user_card = ?, user_name = ?, type = ?, comment = ?');
    $insertLog->execute(array($page, $user_id, $user_card, $name, $type, $comment));

}