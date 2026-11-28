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



<?php require_once ROOT_PATH . '/actions/functions/sessionInit.php'; if (isset($_POST['validateDelete2'])){
        if($_SESSION['grade'] == 1 OR $_SESSION['grade'] == 2){
            
        $id = $_GET['id'];

        // Retrieve user information before deletion for logging
        $getUser = $db->prepare('SELECT id, first_name, last_name FROM users WHERE id = ?');
        $getUser->execute(array($id));
        $usersInfos = $getUser->fetch();

        $DeleteUserAccount = $db->prepare('DELETE FROM users WHERE id = ?');
        $DeleteUserAccount->execute(array($id));

        SaveLog($db, $_SERVER['REQUEST_URI'], 'Account deleted', 'The account of ' . htmlspecialchars($usersInfos['first_name'] ?? '') . ' ' . htmlspecialchars($usersInfos['last_name'] ?? '') . ' was deleted.');

        header('Location: ' . url('gestion/users.php'));
        
    }else{
        $msg = bookfind_translate('You do not have sufficient permissions to delete this user.');
    }
}
