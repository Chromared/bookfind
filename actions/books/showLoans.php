<?php
//This file belongs to the BookFind project.
//
//BookFind is distributed under the terms of the GNU Affero General Public License v3.0.
//
//Copyright (C) 2025 Chromared
?>


<?php if (isset($_GET['id']) AND !empty($_GET['id'])){
    $id = htmlspecialchars($_GET['id']); 
    $Now = date("Y-m-d");

    if($id == $_SESSION['id'] OR $_SESSION['grade'] !== 0){

      $selectLoans1 = $db->prepare('SELECT * FROM loans WHERE borrower_id = ? AND status = 1 AND due_date < ? ORDER BY due_date');
      $selectLoans1->execute(array($id, $Now));

      $selectLoans2 = $db->prepare('SELECT * FROM loans WHERE borrower_id = ? AND status = 1 AND due_date = ? ORDER BY due_date');
      $selectLoans2->execute(array($id, $Now));

      $selectLoans3 = $db->prepare('SELECT * FROM loans WHERE borrower_id = ? AND status = 1 AND due_date > ? ORDER BY due_date');
      $selectLoans3->execute(array($id, $Now));

      $selectLoans4 = $db->prepare('SELECT * FROM loans WHERE borrower_id = ? AND status = 2 ORDER BY return_date DESC');
      $selectLoans4->execute(array($id));

      if($id != $_SESSION['id']){

        SaveLog($db, $_SERVER['REQUEST_URI'], 'Loans viewed', 'No comment');

      }
    
    }
}
