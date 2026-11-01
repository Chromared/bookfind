<?php
//This file belongs to the BookFind project.
//
//BookFind is distributed under the terms of the GNU Affero General Public License v3.0.
//
//Copyright (C) 2025 Chromared
?>



<?php if (isset($_POST['validateSchoolInfo'])) {
    if (isset($_POST['class_name'])){
        if (!empty($_POST['class_name'])){

            $class_name = $_POST['class_name'];
            $id = $_SESSION['id'];

            $checkIfClassAlreadyExists = $db->prepare('SELECT name FROM classes WHERE name = ?');
            $checkIfClassAlreadyExists->execute(array($class_name));

            if($checkIfClassAlreadyExists->rowCount() > 0){
                
                $updateSchoolInfo = $db->prepare('UPDATE users SET class_name = ? WHERE id = ?');
                $updateSchoolInfo->execute(array($class_name, $id));

                if($class_name != $_SESSION['class_name']){
                    SaveLog($db, $_SERVER['REQUEST_URI'], 'Account modified', 'Class changed. Old class: ' . $_SESSION['class_name'] . '. New class: ' . $class_name . '.');
                }

                $_SESSION['class_name'] = $class_name;

                header('Location: updateProfile.php?id=' . $id .'&msg2=true');

            }else{ $errorMsg2 = 'The selected class does not exist.'; }   
        }else{ $errorMsg2 = 'All fields must be filled in.'; }
    }else{ $errorMsg2 = 'Not all fields exist. Reload the page <a href="updateProfile.php?id=' . $id . '">here</a>.'; }
}