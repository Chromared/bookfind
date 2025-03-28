<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2025 Chromared
?>

<?php $selectGenres= $bdd->query('SELECT DISTINCT genre FROM books');

    //if(isset($['genre'])){
        //while($genres = $selectGenres->fetch()){
            //echo '<option value="' . $genres['genre'] . '" ' . SelectedWithoutEcho($genres['genre'], $['genres']) . '>' . $genres['genre'] . '</option>';
        //}
    //}else{

    while($genres = $selectGenres->fetch()){
        echo '<option value="' . $genres['genre'] . '">' . $genres['genre'] . '</option>';
    }//}