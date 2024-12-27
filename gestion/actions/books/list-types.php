<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2024 Chromared
?>

<?php $selectTypes= $bdd->query('SELECT type FROM books');

    //if(isset($['types'])){
        //while($types = $selectTypes->fetch()){
            //echo '<option value="' . $types['type'] . '" ' . SelectedWithoutEcho($types['type'], $['type']) . '>' . $types['type'] . '</option>';
        //}
    //}else{

    while($types = $selectTypes->fetch()){
        echo '<option value="' . $types['type'] . '">' . $types['type'] . '</option>';
    }//}