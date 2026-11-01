<?php
//This file belongs to the BookFind project.
//
//BookFind is distributed under the terms of the GNU Affero General Public License v3.0.
//
//Copyright (C) 2025 Chromared
?>



<?php if (isset($_POST['validateDelete2'])){

        $checkPassword = $db->prepare('DELETE FROM users WHERE id = ?');
        $checkPassword->execute(array($id));

        SaveLog($db, $_SERVER['REQUEST_URI'], 'Account deleted', 'No comment.');
        
        header('Location: actions/users/logoutAction.php');
}