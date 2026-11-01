<?php
//This file belongs to the BookFind project.
//
//BookFind is distributed under the terms of the GNU Affero General Public License v3.0.
//
//Copyright (C) 2025 Chromared
?>



<?php require_once __DIR__ . '/../../../actions/functions/sessionInit.php'; if(isset($_POST['classAddValidate'])){
    $newClass = $_POST['newClass'];

    $checkIfClassAlreadyExists = $db->prepare('SELECT name FROM classes WHERE name = ?');
    $checkIfClassAlreadyExists->execute(array($newClass));

    if($checkIfClassAlreadyExists->rowCount() == 0){

    $addClass = $db->prepare('INSERT INTO classes SET name = ?');
    $addClass->execute(array($newClass));

    SaveLog($db, $_SERVER['REQUEST_URI'], 'Class added', 'The class "' . htmlspecialchars($newClass) . '" was added.');

    header('Location: bookfind.php?tab=classes&successAddClass#addClass');

    }else{ $msgC1 = 'This class already exists.'; }
}