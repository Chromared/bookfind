<?php require_once ROOT_PATH . '/actions/functions/sessionInit.php';
require_once ROOT_PATH . '/actions/users/securityAction.php';
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

        $book = (int)$_POST['id'];
        $user_id = (int)$_POST['user_id'];
        $db->beginTransaction();

        try {
            $selectLoan = $db->prepare('SELECT id FROM loans WHERE book_id = ? AND borrower_id = ? AND status = 1 FOR UPDATE');
            $selectLoan->execute([$book, $user_id]);

            if ($selectLoan->fetchColumn() !== false) {
                $updateLoan = $db->prepare('UPDATE loans SET status = ?, return_date = NOW() WHERE book_id = ? AND borrower_id = ? AND status = 1');
                $updateLoan->execute([2, $book, $user_id]);

                $updateLoanForBooks = $db->prepare('UPDATE books SET status = ? WHERE id = ?');
                $updateLoanForBooks->execute([2, $book]);

                $selectUser = $db->prepare('SELECT loans_count FROM users WHERE id = ? FOR UPDATE');
                $selectUser->execute([$user_id]);
                $userLoans = $selectUser->fetch();
                if ($userLoans) {
                    $updateMaxLoanUser = $db->prepare('UPDATE users SET loans_count = ? WHERE id = ?');
                    $updateMaxLoanUser->execute([max(0, (int)$userLoans['loans_count'] - 1), $user_id]);
                }

                $db->commit();
                SaveLog($db, $_SERVER['REQUEST_URI'], 'Loan return', 'No comment');

                header('Location: ' . url('gestion/loan.php?id=' . rawurlencode((string)$book) . '&user_id=' . rawurlencode((string)$user_id)));
                exit;
            }

            $db->rollBack();
            $msgReturnLoan = bookfind_translate('This loan is no longer active.');
        } catch (Throwable $exception) {
            if ($db->inTransaction()) {
                $db->rollBack();
            }
            throw $exception;
        }
    }
}