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



<?php require_once __DIR__ . '/../../../actions/functions/sessionInit.php'; if(isset($_POST['classAddValidate'])){
    $newClass = $_POST['newClass'];

    $checkIfClassAlreadyExists = $db->prepare('SELECT name FROM classes WHERE name = ?');
    $checkIfClassAlreadyExists->execute(array($newClass));

    if($checkIfClassAlreadyExists->rowCount() == 0){

    $addClass = $db->prepare('INSERT INTO classes SET name = ?');
    $addClass->execute(array($newClass));

    SaveLog($db, $_SERVER['REQUEST_URI'], 'Class added', 'The class "' . htmlspecialchars($newClass) . '" was added.');

    header('Location: bookfind.php?tab=classes&successAddClass#addClass');

    }else{ $msgC1 = bookfind_translate('This class already exists.'); }
}