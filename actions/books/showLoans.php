<?php
//This file belongs to the BookFind project.
//Copyright (C) 2026 Chromared
//
//This program is free software: you can redistribute it and/or modify
//it under the terms of the GNU Affero General Public License as
//published by the Free Software Foundation, either version 3 of the
//License, or (at your option) any later version.
//
//This program is distributed in the hope that it will be useful,
//but WITHOUT ANY WARRANTY; without even the implied warranty of
//MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//GNU Affero General Public License for more details.
//
//You should have received a copy of the GNU Affero General Public License
//along with this program.  If not, see <https://www.gnu.org/licenses/>.
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
