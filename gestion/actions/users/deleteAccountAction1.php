<?php
//This file belongs to the BookFind project.
//
//BookFind is distributed under the terms of the GNU Affero General Public License v3.0.
//
//Copyright (C) 2025 Chromared
?>



<?php require_once __DIR__ . '/../../../actions/functions/sessionInit.php'; if(isset($_POST['validateDelete1'])){

        $id = $_GET['id'];

        $checkPassword = $db->prepare('SELECT loans_count FROM users WHERE id = ?');
        $checkPassword->execute(array($id));

        $InfoDelete = $checkPassword->fetch();

        if($InfoDelete['loans_count'] == '0'){

            $deleteAccount = true;

    }else{
        $errorMsg4 = 'You must return all your loans before deleting your account. You currently have ' . $InfoDelete['loans_count'] . ' book(s) on loan.';
    }
}