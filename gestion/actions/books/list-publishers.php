<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2025 Chromared
?>

<?php $selectPublishers= $bdd->query('SELECT DISTINCT editeur FROM books');

    //if(isset($['editeurs'])){
        //while($publishers = $selectPublishers->fetch()){
            //echo '<option value="' . $publishers['editeur'] . '" ' . SelectedWithoutEcho($publishers['editeur'], $['editeur']) . '>' . $publishers['editeur'] . '</option>';
        //}
    //}else{

    while($publishers = $selectPublishers->fetch()){
        echo '<option value="' . $publishers['editeur'] . '">' . $publishers['editeur'] . '</option>';
    }//}