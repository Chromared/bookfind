<?php require_once __DIR__ . '/../../../actions/functions/sessionInit.php';
require_once __DIR__ . '/../../../actions/users/securityAction.php';
//This file belongs to the BookFind project.
//
//BookFind is distributed under the terms of the GNU Affero General Public License v3.0.
//
//Copyright (C) 2025 Chromared
?>


<?php $Now = date("Y-m-d");

    $selectLoans1 = $db->prepare('SELECT * FROM loans WHERE status = 1 AND due_date < ? ORDER BY due_date');
    $selectLoans1->execute(array($Now));

    $selectLoans2 = $db->prepare('SELECT * FROM loans WHERE status = 1 AND due_date = ? ORDER BY due_date');
    $selectLoans2->execute(array($Now));

    $selectLoans3 = $db->prepare('SELECT * FROM loans WHERE status = 1 AND due_date > ? ORDER BY due_date');
    $selectLoans3->execute(array($Now));

    $selectLoans4 = $db->query('SELECT * FROM loans WHERE status = 2 ORDER BY return_date DESC');
