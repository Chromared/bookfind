<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2025 Chromared
?>

<?php $selectAuthors= $bdd->query('SELECT DISTINCT auteur FROM books');

    //if(isset($['auteur'])){
        //while($authors = $selectAuthors->fetch()){
            //echo '<option value="' . $authors['auteur'] . '" ' . SelectedWithoutEcho($authors['auteur'], $['auteur']) . '>' . $authors['auteur'] . '</option>';
        //}
    //}else{

    while($authors = $selectAuthors->fetch()){
        echo '<option value="' . $authors['auteur'] . '">' . $authors['auteur'] . '</option>';
    }//}