<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2024 Chromared
?>

<?php $selectSeries= $bdd->query('SELECT serie FROM books');

    //if(isset($['series'])){
        //while($series = $selectSeries->fetch()){
            //echo '<option value="' . $series['serie'] . '" ' . SelectedWithoutEcho($series['serie'], $['serie']) . '>' . $series['serie'] . '</option>';
        //}
    //}else{

    while($series = $selectSeries->fetch()){
        echo '<option value="' . $series['serie'] . '">' . $series['serie'] . '</option>';
    }//}