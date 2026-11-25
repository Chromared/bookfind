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



<?php if(isset($_POST['validateUpdate'])){
    if(isset($_POST['date']) AND !empty($_POST['date']) AND isset($_POST['id']) AND !empty($_POST['id']) AND isset($_POST['user_id']) AND !empty($_POST['user_id'])){

        $date = $_POST['date'];
        $book = $_POST['id'];
        $user = $_POST['user_id'];

        $updateLoan = $db->prepare('UPDATE loans SET due_date = ? WHERE book_id = ? AND borrower_id = ? AND status = 1');
        $updateLoan->execute(array($date, $book, $user));

        header('Location: loan.php?id=' . $book . '&user_id=' . $user . '&success');

}}