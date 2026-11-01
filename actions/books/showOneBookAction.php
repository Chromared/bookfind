<?php
//This file belongs to the BookFind project.
//
//BookFind is distributed under the terms of the GNU Affero General Public License v3.0.
//
//Copyright (C) 2025 Chromared
?>



<?php if(isset($_GET['id']) AND !empty($_GET['id'])){

      $id = $_GET['id'];
      $selectInfosFromBooks= $db->prepare('SELECT * FROM books WHERE id = ?');
      $selectInfosFromBooks->execute(array($id));

      $booksInfos = $selectInfosFromBooks->fetch();
      
}else{die('Variable d\'URL (GET) manquante');}