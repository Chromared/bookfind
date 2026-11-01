<?php
//This file belongs to the BookFind project.
//
//BookFind is distributed under the terms of the GNU Affero General Public License v3.0.
//
//Copyright (C) 2025 Chromared
?>



<?php $selectClasses= $db->query('SELECT name FROM classes');

    if(isset($usersInfos['class_name'])){
        while($classes = $selectClasses->fetch()){
            echo '<option value="' . htmlspecialchars($classes['name']) . '" ' . SelectedWithoutEcho(htmlspecialchars($classes['name']), $usersInfos['class_name']) . '>' . $classes['name'] . '</option>';
        }
    }else{

    while($classes = $selectClasses->fetch()){
        echo '<option value="' . htmlspecialchars($classes['name']) . '">' . htmlspecialchars($classes['name']) . '</option>';
    }}