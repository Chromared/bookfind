<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2024 Chromared
?>


<?php $id = htmlspecialchars($_GET['id']);
      $selectInfosFromEmprunts= $bdd->prepare('SELECT * FROM emprunts WHERE id_book = ?');
      $selectInfosFromEmprunts->execute(array($id));

      $empruntInfos = $selectInfosFromEmprunts->fetch();