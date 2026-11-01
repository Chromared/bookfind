<?php
//This file belongs to the BookFind project.
//
//BookFind is distributed under the terms of the GNU Affero General Public License v3.0.
//
//Copyright (C) 2025 Chromared
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
        $errorMsg3 = 'Your current password is incorrect.';
}
}else{
    $errorMsg3 = 'The two new passwords are not identical.';
}
}else{
    $errorMsg3 = 'Please fill in all fields.';
}
}else{
    $errorMsg3 = 'Not all fields exist. Please <a href="updateProfile.php?id=' . $id . '">reload</a> the page.';
}
}