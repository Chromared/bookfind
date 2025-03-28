<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2025 Chromared
?>


<?php $id = htmlspecialchars($_GET['id']);
      if(isset($booksInfos)){
      if($booksInfos['statut'] == 1){

      $selectInfosFromEmprunts= $bdd->prepare('SELECT * FROM emprunts WHERE id_book = ? AND statut = ?');
      $selectInfosFromEmprunts->execute(array($id, 1));

      $emprunt = $selectInfosFromEmprunts->fetch();
      }}