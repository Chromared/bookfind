<?php require_once __DIR__ . '/../../../actions/functions/sessionInit.php';
require_once __DIR__ . '/../../../actions/users/securityAction.php';
//This file belongs to the BookFind project.
//
//BookFind is distributed under the terms of the GNU Affero General Public License v3.0.
//
//Copyright (C) 2025 Chromared
?>

<?php $selectSeries= $db->query('SELECT DISTINCT series FROM books');

    //if(isset($['series'])){
        //while($series = $selectSeries->fetch()){
            //echo '<option value="' . $series['series'] . '" ' . SelectedWithoutEcho($series['series'], $['series']) . '>' . $series['series'] . '</option>';
        //}
    //}else{

    while($series = $selectSeries->fetch()){
        echo '<option value="' . $series['series'] . '">' . $series['series'] . '</option>';
    }//}