<?php require_once __DIR__ . '/../../../actions/functions/sessionInit.php';
require_once __DIR__ . '/../../../actions/users/securityAction.php';
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