<?php require_once __DIR__ . '/../../../actions/functions/sessionInit.php';
require_once __DIR__ . '/../../../actions/users/securityAction.php';
//This file belongs to the BookFind project.
//
//BookFind is distributed under the terms of the GNU Affero General Public License v3.0.
//
//Copyright (C) 2025 Chromared
?>

<?php $selectPublishers= $db->query('SELECT DISTINCT publisher FROM books');

    //if(isset($['editeurs'])){
        //while($publishers = $selectPublishers->fetch()){
            //echo '<option value="' . $publishers['publisher'] . '" ' . SelectedWithoutEcho($publishers['publisher'], $['publisher']) . '>' . $publishers['publisher'] . '</option>';
        //}
    //}else{

    while($publishers = $selectPublishers->fetch()){
        echo '<option value="' . $publishers['publisher'] . '">' . $publishers['publisher'] . '</option>';
    }//}