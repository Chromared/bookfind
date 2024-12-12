<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2024 Chromared
?>


<?php $card = htmlspecialchars($_GET['card']);

      $selectInfosFromEmprunts1= $bdd->prepare('SELECT * FROM emprunts WHERE card_emprunteur = ? AND statut = 1 ORDER BY date_futur_retour');
      $selectInfosFromEmprunts1->execute(array($card));
      
      $selectInfosFromEmprunts2= $bdd->prepare('SELECT * FROM emprunts WHERE card_emprunteur = ? AND statut = 2 ORDER BY date_retour DESC');
      $selectInfosFromEmprunts2->execute(array($card));