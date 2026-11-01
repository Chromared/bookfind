<?php require_once __DIR__ . '/../../../actions/functions/sessionInit.php';
require_once __DIR__ . '/../../../actions/users/securityAction.php';
//This file belongs to the BookFind project.
//
//BookFind is distributed under the terms of the GNU Affero General Public License v3.0.
//
//Copyright (C) 2025 Chromared
?>

<?php $selectGenres= $db->query('SELECT DISTINCT genre FROM books');

    //if(isset($['genre'])){
        //while($genres = $selectGenres->fetch()){
            //echo '<option value="' . $genres['genre'] . '" ' . SelectedWithoutEcho($genres['genre'], $['genres']) . '>' . $genres['genre'] . '</option>';
        //}
    //}else{

    while($genres = $selectGenres->fetch()){
        echo '<option value="' . $genres['genre'] . '">' . $genres['genre'] . '</option>';
    }//}