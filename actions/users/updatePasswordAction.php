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



<?php if (isset($_POST['validatePassword'])) {
    if (isset($_POST['actual-password']) AND isset($_POST['new-password']) AND isset($_POST['confirm-new-password'])) {
    if (!empty($_POST['actual-password']) AND !empty($_POST['new-password']) AND !empty($_POST['confirm-new-password'])) {

        if ($_POST['new-password'] == $_POST['confirm-new-password']) {
            
        $password = $_POST['actual-password'];
        $newPassword = password_hash($_POST['new-password'], PASSWORD_DEFAULT);
        $id = $_SESSION['id'];

        $checkPassword = $db->prepare('SELECT password FROM users WHERE id = ?');
        $checkPassword->execute(array($id));

        $Password = $checkPassword->fetch();

        if (password_verify($password, $Password['password'])) {
            
            $checkPassword->closeCursor();

            $updatePassword = $db->prepare('UPDATE users SET password = ? WHERE id = ?');
            $updatePassword->execute(array($newPassword, $id));

            SaveLog($db, $_SERVER['REQUEST_URI'], 'Account modified', 'Password changed.');


            header('Location: updateProfile.php?id=' . $id .'&msg3=true');

    }else{
        $errorMsg3 = bookfind_translate('Your current password is incorrect.');
}
}else{
    $errorMsg3 = bookfind_translate('The two new passwords are not identical.');
}
}else{
    $errorMsg3 = bookfind_translate('Please fill in all fields.');
}
}else{
    $errorMsg3 = bookfind_translate('Not all fields exist. Please') . ' <a href="updateProfile.php?id=' . $id . '">' . bookfind_translate('reload') . '</a> ' . bookfind_translate('the page.');
}
}