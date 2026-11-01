<?php require_once __DIR__ . '/../../../actions/functions/sessionInit.php';
require_once __DIR__ . '/../../../actions/users/securityAction.php';
//This file belongs to the BookFind project.
//
//BookFind is distributed under the terms of the GNU Affero General Public License v3.0.
//
//Copyright (C) 2025 Chromared
?>

<?php $selectTypes= $db->query('SELECT DISTINCT type FROM books');

    //if(isset($['types'])){
        //while($types = $selectTypes->fetch()){
            //echo '<option value="' . $types['type'] . '" ' . SelectedWithoutEcho($types['type'], $['type']) . '>' . $types['type'] . '</option>';
        //}
    //}else{

    while($types = $selectTypes->fetch()){
        echo '<option value="' . $types['type'] . '">' . $types['type'] . '</option>';
    }//}