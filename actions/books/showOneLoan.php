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


<?php $id = htmlspecialchars($_GET['id']);
      if(isset($booksInfos)){
      if($booksInfos['status'] == 1){

      $selectLoans= $db->prepare('SELECT * FROM loans WHERE book_id = ? AND status = ?');
      $selectLoans->execute(array($id, 1));

      $loan = $selectLoans->fetch();
      }}