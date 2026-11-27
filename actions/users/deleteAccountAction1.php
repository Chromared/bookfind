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
        $id = $_SESSION['id'];

        $checkPassword = $db->prepare('SELECT password, loans_count FROM users WHERE id = ?');
        $checkPassword->execute(array($id));

        $InfoDelete = $checkPassword->fetch();

        if($InfoDelete['loans_count'] == '0'){

        if (password_verify($password, $InfoDelete['password'])) {

            $deleteAccount = true;
        
        }else{
            $errorMsg4 = bookfind_translate('Your current password is incorrect.');
        }

    }else{
        $errorMsg4 = sprintf(bookfind_translate('You must return all your loans before deleting your account. You currently have %d book(s) still on loan.'), $InfoDelete['loans_count']);
    }

    }else{
        $errorMsg4 = bookfind_translate('Please fill in all fields.');
    }
}else{
    $errorMsg4 = bookfind_translate('Not all fields exist. Please') . ' <a href="updateProfile.php?id=' . $id . '">' . bookfind_translate('reload') . '</a> ' . bookfind_translate('the page.');
}
}