<?php
//This file belongs to the BookFind project.
//
//BookFind is distributed under the terms of the GNU Affero General Public License v3.0.
//
//Copyright (C) 2025 Chromared
?>



<?php require_once __DIR__ . '/../../../actions/functions/sessionInit.php'; if (isset($_POST['validateDelete2'])){
        if($_SESSION['grade'] == 1 OR $_SESSION['grade'] == 2){
            
        $id = $_GET['id'];

        // Retrieve user information before deletion for logging
        $getUser = $db->prepare('SELECT id, first_name, last_name FROM users WHERE id = ?');
        $getUser->execute(array($id));
        $usersInfos = $getUser->fetch();

        $DeleteUserAccount = $db->prepare('DELETE FROM users WHERE id = ?');
        $DeleteUserAccount->execute(array($id));

        SaveLog($db, $_SERVER['REQUEST_URI'], 'Account deleted', 'The account of ' . htmlspecialchars($usersInfos['first_name'] ?? '') . ' ' . htmlspecialchars($usersInfos['last_name'] ?? '') . ' was deleted.');

        header('Location: users.php');
        
    }else{
        $msg = 'You do not have sufficient permissions to delete this user.';
    }
}
