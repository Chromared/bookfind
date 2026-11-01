<?php require_once __DIR__ . '/../../../actions/functions/sessionInit.php';
require_once __DIR__ . '/../../../actions/users/securityAction.php';
//This file belongs to the BookFind project.
//
//BookFind is distributed under the terms of the GNU Affero General Public License v3.0.
//
//Copyright (C) 2025 Chromared
?>

<?php $selectAuthors= $db->query('SELECT DISTINCT author FROM books');

    //if(isset($['author'])){
        //while($authors = $selectAuthors->fetch()){
            //echo '<option value="' . $authors['author'] . '" ' . SelectedWithoutEcho($authors['author'], $['author']) . '>' . $authors['author'] . '</option>';
        //}
    //}else{

    while($authors = $selectAuthors->fetch()){
        echo '<option value="' . $authors['author'] . '">' . $authors['author'] . '</option>';
    }//}