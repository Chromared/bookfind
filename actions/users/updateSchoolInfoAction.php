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

            }else{ $errorMsg2 = bookfind_translate('The selected class does not exist.'); }
        }else{ $errorMsg2 = bookfind_translate('All fields must be filled in.'); }
    }else{ $errorMsg2 = bookfind_translate('Not all fields exist. Reload the page') . ' <a href="updateProfile.php?id=' . $id . '">' . bookfind_translate('here') . '</a>.'; }
}