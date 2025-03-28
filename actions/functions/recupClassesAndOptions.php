<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2025 Chromared
?>



<?php $selectClasses= $bdd->query('SELECT name FROM classes');

    if(isset($usersInfos['classe'])){
        while($classes = $selectClasses->fetch()){
            echo '<option value="' . htmlspecialchars($classes['name']) . '" ' . SelectedWithoutEcho(htmlspecialchars($classes['name']), $usersInfos['classe']) . '>' . $classes['name'] . '</option>';
        }
    }else{

    while($classes = $selectClasses->fetch()){
        echo '<option value="' . htmlspecialchars($classes['name']) . '">' . htmlspecialchars($classes['name']) . '</option>';
    }}