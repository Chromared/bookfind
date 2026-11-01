<?php
//This file belongs to the BookFind project.
//
//BookFind is distributed under the terms of the GNU Affero General Public License v3.0.
//
//Copyright (C) 2025 Chromared
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
            $errorMsg4 = 'Your current password is incorrect.';
        }

    }else{
        $errorMsg4 = 'You must return all your loans before deleting your account. You currently have ' . $InfoDelete['loans_count'] . ' book(s) still on loan.';
    }

    }else{
        $errorMsg4 = 'Please fill in all fields.';
    }
}else{
    $errorMsg4 = 'Not all fields exist. Please <a href="updateProfile.php?id=' . $id . '">reload</a> the page.';
}
}