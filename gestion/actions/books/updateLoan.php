<?php require_once __DIR__ . '/../../../actions/functions/sessionInit.php';
require_once __DIR__ . '/../../../actions/users/securityAction.php';
//This file belongs to the BookFind project.
//
//BookFind is distributed under the terms of the GNU Affero General Public License v3.0.
//
//Copyright (C) 2025 Chromared
?>



<?php if(isset($_POST['validateUpdate'])){
    if(isset($_POST['date']) AND !empty($_POST['date']) AND isset($_POST['id']) AND !empty($_POST['id']) AND isset($_POST['user_id']) AND !empty($_POST['user_id'])){

        $date = $_POST['date'];
        $book = $_POST['id'];
        $user = $_POST['user_id'];

        $updateLoan = $db->prepare('UPDATE loans SET due_date = ? WHERE book_id = ? AND borrower_id = ? AND status = 1');
        $updateLoan->execute(array($date, $book, $user));

        header('Location: loan.php?id=' . $book . '&user_id=' . $user . '&success');

}}