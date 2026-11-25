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



<?php require_once __DIR__ . '/../../../actions/functions/sessionInit.php'; if(isset($_POST['classUpdateValidate'])){
    $existingClass = $_POST['existingClass'];
    $newClass = $_POST['newClassName'];

    $checkIfClassAlreadyExists = $db->prepare('SELECT name FROM classes WHERE name = ?');
    $checkIfClassAlreadyExists->execute(array($existingClass));

    if($checkIfClassAlreadyExists->rowCount() != 0){

    $addClass = $db->prepare('UPDATE classes SET name = ? WHERE name = ?');
    $addClass->execute(array($newClass, $existingClass));

    $updateClassForUsers = $db->prepare('UPDATE users SET class_name = ? WHERE class_name = ?');
    $updateClassForUsers->execute(array($newClass, $existingClass));

    SaveLog($db, $_SERVER['REQUEST_URI'], 'Class modified', 'The class "' . htmlspecialchars($existingClass) . '" was renamed to ' . htmlspecialchars($newClass) . '.');

    header('Location: bookfind.php?tab=classes&successUpdateClass#updateClass');

    }else{ $msgC2 = bookfind_translate('The class you want to modify does not exist.'); }
}