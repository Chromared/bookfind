<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2024 Chromared
?>


<?php $id = htmlspecialchars($_GET['id']);
      if($booksInfos['statut'] == 1){

      $selectInfosFromEmprunts= $bdd->prepare('SELECT * FROM emprunts WHERE id_book = ? AND statut = 1');
      $selectInfosFromEmprunts->execute(array($id));

      $emprunt = $selectInfosFromEmprunts->fetch();
      }