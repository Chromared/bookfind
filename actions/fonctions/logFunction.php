<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2024 Chromared
?>



<?php function Log($page, $type, $comment){

    //$type correspond au type de log. 1 = inscription, 2 = connexion, ...

    $userSystem = $_SERVER['HTTP_USER_AGENT'];
    $browserInfo = get_browser($userSystem, true);

    $user_id = $_SESSION['id'];
    $user_card = $_SESSION['card'];
    $browser = $browserInfo['browser'];
    $version = $browserInfo['version'];
    $os = $browserInfo['platform'];

    if(isset($bdd)){

    $insertLog = $bdd->prepare('INSERT INTO log SET page = ?, user_id = ?, user_card = ?, browser = ?, version = ?, os = ?, type = ?, comment = ?');
    $insertLog->execute(array($page, $user_id, $user_card, $browser, $version, $os, $type, $comment));

    }

}