<?php require_once __DIR__ . '/../../../actions/functions/sessionInit.php';
require_once __DIR__ . '/../../../actions/users/securityAction.php';
//This file belongs to the BookFind project.
//
//BookFind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2025 Chromared
?>

<?php $selectSeries= $bdd->query('SELECT DISTINCT serie FROM books');

    //if(isset($['series'])){
        //while($series = $selectSeries->fetch()){
            //echo '<option value="' . $series['serie'] . '" ' . SelectedWithoutEcho($series['serie'], $['serie']) . '>' . $series['serie'] . '</option>';
        //}
    //}else{

    while($series = $selectSeries->fetch()){
        echo '<option value="' . $series['serie'] . '">' . $series['serie'] . '</option>';
    }//}