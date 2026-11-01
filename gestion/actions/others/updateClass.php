<?php
//This file belongs to the BookFind project.
//
//BookFind is distributed under the terms of the GNU Affero General Public License v3.0.
//
//Copyright (C) 2025 Chromared
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

    }else{ $msgC2 = 'The class you want to modify does not exist.'; }
}