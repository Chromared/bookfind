<?php require_once __DIR__ . '/../../../actions/functions/sessionInit.php';
require_once __DIR__ . '/../../../actions/users/securityAction.php';
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

<?php $selectTypes= $db->query('SELECT DISTINCT type FROM books');

    //if(isset($['types'])){
        //while($types = $selectTypes->fetch()){
            //echo '<option value="' . $types['type'] . '" ' . SelectedWithoutEcho($types['type'], $['type']) . '>' . $types['type'] . '</option>';
        //}
    //}else{

    while($types = $selectTypes->fetch()){
        echo '<option value="' . $types['type'] . '">' . $types['type'] . '</option>';
    }//}