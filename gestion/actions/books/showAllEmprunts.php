<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2024 Chromared
?>


<?php $Now = date("Y-m-d");

    $selectInfosFromEmprunts1 = $bdd->prepare('SELECT * FROM emprunts WHERE statut = 1 AND date_futur_retour < ? ORDER BY date_futur_retour');
    $selectInfosFromEmprunts1->execute(array($Now));

    $selectInfosFromEmprunts2 = $bdd->prepare('SELECT * FROM emprunts WHERE statut = 1 AND date_futur_retour = ? ORDER BY date_futur_retour');
    $selectInfosFromEmprunts2->execute(array($Now));

    $selectInfosFromEmprunts3 = $bdd->prepare('SELECT * FROM emprunts WHERE statut = 1 AND date_futur_retour > ? ORDER BY date_futur_retour');
    $selectInfosFromEmprunts3->execute(array($Now));

    $selectInfosFromEmprunts4 = $bdd->query('SELECT * FROM emprunts WHERE statut = 2 ORDER BY date_retour DESC');
