<?php
//This file belongs to the BookFind project.
//
//BookFind is distributed under the terms of the GNU Affero General Public License v3.0.
//
//Copyright (C) 2025 Chromared
?>



<?php require_once __DIR__ . '/../../../actions/functions/sessionInit.php';
require_once __DIR__ . '/../../../actions/users/securityAction.php';
require_once __DIR__ . '/../../actions/users/securityAdminAction.php';
if(isset($_POST['validateAdd'])){
    if(isset($_POST['user_id']) AND isset($_POST['date'])){
    if(!empty($_POST['user_id']) AND !empty($_POST['date'])){

        $book = $_GET['id'];

        // If $booksInfos is not defined (possible direct call), retrieve it
        if (!isset($booksInfos) && isset($book)) {
            $selectInfosFromBooks= $db->prepare('SELECT * FROM books WHERE id = ?');
            $selectInfosFromBooks->execute(array($book));
            $booksInfos = $selectInfosFromBooks->fetch();
        }
        $user_id = $_POST['user_id'];
        $date = $_POST['date'];

        $checkIfUserAlreadyExists = $db->prepare('SELECT * FROM users WHERE id = ?');
        $checkIfUserAlreadyExists->execute(array($user_id));
        $user = $checkIfUserAlreadyExists->fetch();

        if($checkIfUserAlreadyExists->rowCount() > 0){
        if($booksInfos['status'] != 1){
        if($user['loans_count'] < $user['max_loans']){

            $borrower_name = $user['first_name'] . ' ' . $user['last_name'];
            
            $addLoan = $db->prepare('INSERT INTO loans SET book_id = ?, due_date = ?, borrower_id = ?, borrower_name = ?, status = ?, book_title = ?');
            $addLoan->execute(array($book, $date, $user_id, $borrower_name, 1, $booksInfos['title']));

            $updateLoanForBooks = $db->prepare('UPDATE books SET status = ? WHERE id = ?');
            $updateLoanForBooks->execute(array(1, $book));
            
            $user_loans_count = $user['loans_count'] + 1;
            $updateUser = $db->prepare('UPDATE users SET loans_count = ? WHERE id = ?');
            $updateUser->execute(array($user_loans_count, $user_id));

            SaveLog($db, $_SERVER['REQUEST_URI'], 'Book loan', 'The book ' . htmlspecialchars($booksInfos['title']) . ' was loaned.');

            header('Location: loan.php?id=' . $book . '&user_id=' . $user_id);

    }else{$msg1 = 'This user has reached their loan limit.';}
    }else{$msg1 = 'This book is already on loan.';}
    }else{$msg1 = 'This user does not exist.';}
    }else{$msg1 = 'Not all fields are filled in.';}
    }else{$msg1 = 'Not all fields exist.';}
}