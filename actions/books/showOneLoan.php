<?php
//This file belongs to the BookFind project.
//
//BookFind is distributed under the terms of the GNU Affero General Public License v3.0.
//
//Copyright (C) 2025 Chromared
?>


<?php $id = htmlspecialchars($_GET['id']);
      if(isset($booksInfos)){
      if($booksInfos['status'] == 1){

      $selectLoans= $db->prepare('SELECT * FROM loans WHERE book_id = ? AND status = ?');
      $selectLoans->execute(array($id, 1));

      $loan = $selectLoans->fetch();
      }}