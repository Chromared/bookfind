<?php
//This file belongs to the BookFind project.
//
//BookFind is distributed under the terms of the GNU Affero General Public License v3.0.
//
//Copyright (C) 2025 Chromared
?>



<?php require_once __DIR__ . '/../../../actions/functions/sessionInit.php'; if(isset($_POST['classDeleteValidate'])){
    $existingClass = $_POST['existingClass2'];

    $checkIfClassAlreadyExists = $db->prepare('SELECT name FROM classes WHERE name = ?');
    $checkIfClassAlreadyExists->execute(array($existingClass));

    if($checkIfClassAlreadyExists->rowCount() > 0){

    $addClass = $db->prepare('DELETE FROM classes WHERE name = ?');
    $addClass->execute(array($existingClass));

    $updateClassForUsers = $db->prepare('UPDATE users SET class_name = ? WHERE class_name = ?');
    $updateClassForUsers->execute(array('None', $existingClass));

    SaveLog($db, $_SERVER['REQUEST_URI'], 'Class deleted', 'The class "' . htmlspecialchars($existingClass) . '" was deleted. Users in this class were moved to the class "None".');

    header('Location: bookfind.php?tab=classes&successDeleteClass#deleteClass');

    }else{ $msgC3 = 'This class already exists.'; }
}