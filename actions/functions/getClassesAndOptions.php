<?php
//This file belongs to the BookFind project.
//Copyright (C) 2026 Chromared
//
//This program is free software: you can redistribute it and/or modify
//it under the terms of the GNU Affero General Public License as
//published by the Free Software Foundation, either version 3 of the
//License, or (at your option) any later version.
//
//This program is distributed in the hope that it will be useful,
//but WITHOUT ANY WARRANTY; without even the implied warranty of
//MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//GNU Affero General Public License for more details.
//
//You should have received a copy of the GNU Affero General Public License
//along with this program.  If not, see <https://www.gnu.org/licenses/>.
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