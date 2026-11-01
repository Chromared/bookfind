<?php require_once __DIR__ . '/../../../actions/functions/sessionInit.php';
require_once __DIR__ . '/../../../actions/users/securityAction.php';
//This file belongs to the BookFind project.
//
//BookFind is distributed under the terms of the GNU Affero General Public License v3.0.
//
//Copyright (C) 2025 Chromared
?>


<?php $id = htmlspecialchars($_GET['id']);
      $selectLoans= $db->prepare('SELECT * FROM loans WHERE book_id = ? AND status = 1');
      $selectLoans->execute(array($id));

      $loanInfos = $selectLoans->fetch();