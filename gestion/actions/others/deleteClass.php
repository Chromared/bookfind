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



<?php require_once ROOT_PATH . '/actions/functions/sessionInit.php'; if(isset($_POST['classDeleteValidate'])){
    $existingClass = $_POST['existingClass2'];

    $checkIfClassAlreadyExists = $db->prepare('SELECT name FROM classes WHERE name = ?');
    $checkIfClassAlreadyExists->execute(array($existingClass));

    if($checkIfClassAlreadyExists->rowCount() > 0){

    $addClass = $db->prepare('DELETE FROM classes WHERE name = ?');
    $addClass->execute(array($existingClass));

    $updateClassForUsers = $db->prepare('UPDATE users SET class_name = ? WHERE class_name = ?');
    $updateClassForUsers->execute(array('None', $existingClass));

    SaveLog($db, $_SERVER['REQUEST_URI'], 'Class deleted', 'The class "' . htmlspecialchars($existingClass) . '" was deleted. Users in this class were moved to the class "None".');

    header('Location: ' . url('gestion/bookfind.php?tab=classes&successDeleteClass#deleteClass'));

    }else{ $msgC3 = bookfind_translate('This class already exists.'); }
}