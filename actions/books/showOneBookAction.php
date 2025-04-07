<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2025 Chromared
?>



<?php if(isset($_GET['id']) AND !empty($_GET['id'])){

      $id = $_GET['id'];
      $selectInfosFromBooks= $bdd->prepare('SELECT * FROM books WHERE id = ? AND statut = 1');
      $selectInfosFromBooks->execute(array($id));

      $booksInfos = $selectInfosFromBooks->fetch();
      
}else{die('Variable d\'URL (GET) manquante');}