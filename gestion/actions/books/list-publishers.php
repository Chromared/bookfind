<?php require_once ROOT_PATH . '/actions/functions/sessionInit.php';
require_once ROOT_PATH . '/actions/users/securityAction.php';
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

<?php $selectPublishers= $db->query('SELECT DISTINCT publisher FROM books');

    //if(isset($['editeurs'])){
        //while($publishers = $selectPublishers->fetch()){
            //echo '<option value="' . $publishers['publisher'] . '" ' . SelectedWithoutEcho($publishers['publisher'], $['publisher']) . '>' . $publishers['publisher'] . '</option>';
        //}
    //}else{

    while($publishers = $selectPublishers->fetch()){
        echo '<option value="' . $publishers['publisher'] . '">' . $publishers['publisher'] . '</option>';
    }//}