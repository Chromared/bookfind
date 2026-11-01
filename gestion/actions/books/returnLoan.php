<?php require_once __DIR__ . '/../../../actions/functions/sessionInit.php';
require_once __DIR__ . '/../../../actions/users/securityAction.php';
//This file belongs to the BookFind project.
//
//BookFind is distributed under the terms of the GNU Affero General Public License v3.0.
//
//Copyright (C) 2025 Chromared
?>



<?php if(isset($_POST['validateReturn'])){
    if(isset($_POST['id']) AND !empty($_POST['id']) AND isset($_POST['user_id']) AND !empty($_POST['user_id'])){

        $book = $_POST['id'];
        $user_id = $_POST['user_id'];

        $selectNbLoansFromUsers = $db->prepare('SELECT loans_count FROM users WHERE id = ?');
        $selectNbLoansFromUsers->execute(array($user_id));
        $user_loans_count = $selectNbLoansFromUsers->fetch();

        $loans_count = $user_loans_count['loans_count'] - 1;

        $updateLoanForBooks = $db->prepare('UPDATE books SET status = ? WHERE id = ?');
        $updateLoanForBooks->execute(array(2, $book));

        $updateLoan = $db->prepare('UPDATE loans SET status = ?, return_date = NOW() WHERE book_id = ? AND borrower_id = ? AND status = 1');
        $updateLoan->execute(array(2, $book, $user_id));

        $updateMaxLoanUser = $db->prepare('UPDATE users SET loans_count = ? WHERE id = ?');
        $updateMaxLoanUser->execute(array($loans_count, $user_id));

        SaveLog($db, $_SERVER['REQUEST_URI'], 'Loan return', 'No comment');

        header('Location: loan.php?id=' . $book . '&user_id=' . $user_id);
    }
}