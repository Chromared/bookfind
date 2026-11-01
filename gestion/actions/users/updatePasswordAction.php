<?php
//This file belongs to the BookFind project.
//
//BookFind is distributed under the terms of the GNU Affero General Public License v3.0.
//
//Copyright (C) 2025 Chromared
?>



<?php require_once __DIR__ . '/../../../actions/functions/sessionInit.php';
$id = $_GET['id'] ?? null;
if (isset($_POST['validatePassword'])) {
    if ($_SESSION['grade'] == '1' or $_SESSION['grade'] == '2') {
        if (isset($_POST['new-password']) and isset($_POST['confirm-new-password'])) {
            if (!empty($_POST['new-password']) and !empty($_POST['confirm-new-password'])) {

                if ($_POST['new-password'] == $_POST['confirm-new-password']) {

                    $newPassword = password_hash($_POST['new-password'], PASSWORD_DEFAULT);
                    $id = $_GET['id'];

                    $updatePassword = $db->prepare('UPDATE users SET password = ? WHERE id = ?');
                    $updatePassword->execute(array($newPassword, $id));

                    // Retrieve user information for logging
                    $getUser = $db->prepare('SELECT id, first_name, last_name FROM users WHERE id = ?');
                    $getUser->execute(array($id));
                    $usersInfos = $getUser->fetch();

                    SaveLog($db, $_SERVER['REQUEST_URI'], 'Password changed', 'The password of <a href="../profile.php?id=' . ($usersInfos['id'] ?? '') . '">' . htmlspecialchars($usersInfos['first_name'] ?? '') . ' ' . htmlspecialchars($usersInfos['last_name'] ?? '') . '</a> was changed.');

                    header('Location: update-user.php?id=' . $id . '&msg3=true');
                } else {
                    $errorMsg3 = 'The two new passwords are not identical.';
                }
            } else {
                $errorMsg3 = 'Please fill in all fields.';
            }
        } else {
            $errorMsg3 = 'Not all fields exist. Please <a href="update-user.php?id=' . ($id ?? '') . '">reload</a> the page.';
        }
    } else {
        $errorMsg3 = 'You do not have permission to perform this action.';
    }
}
