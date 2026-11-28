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



<?php if(isset($_POST['validateDelete1'])){
    if(isset($_POST['password'])){
        if(!empty($_POST['password'])){

        $password = $_POST['password'];
        $id = (int)($_SESSION['id'] ?? 0);

        $checkPassword = $db->prepare('SELECT password, (SELECT COUNT(*) FROM loans WHERE borrower_id = users.id AND status = 1) AS active_loans FROM users WHERE id = ?');
        $checkPassword->execute(array($id));

        $InfoDelete = $checkPassword->fetch();

        if($InfoDelete && (int)$InfoDelete['active_loans'] === 0){

        if (password_verify($password, $InfoDelete['password'])) {

            $deleteAccount = true;
        
        }else{
            $errorMsg4 = bookfind_translate('Your current password is incorrect.');
        }

    }else{
        $errorMsg4 = sprintf(bookfind_translate('You must return all your loans before deleting your account. You currently have %d book(s) still on loan.'), (int)($InfoDelete['active_loans'] ?? 0));
    }

    }else{
        $errorMsg4 = bookfind_translate('Please fill in all fields.');
    }
}else{
    $errorMsg4 = bookfind_translate('Not all fields exist. Please') . ' <a href="' . htmlspecialchars(url('updateProfile.php?id=' . rawurlencode((string)$id)), ENT_QUOTES, 'UTF-8') . '">' . bookfind_translate('reload') . '</a> ' . bookfind_translate('the page.');
}
}