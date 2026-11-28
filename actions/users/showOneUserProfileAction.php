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



<?php $id = htmlspecialchars($_GET['id']);

      if($id == $_SESSION['id'] OR $_SESSION['grade'] !== 0){       

            $selectInfosFromUsers = $db->prepare('SELECT * FROM users WHERE id = ?');
            $selectInfosFromUsers->execute(array($id));

            $usersInfos = $selectInfosFromUsers->fetch();

            if($id != $_SESSION['id'] AND $selectInfosFromUsers->rowCount() === 1){

                  SaveLog($db, $_SERVER['REQUEST_URI'], 'Profile viewed', 'The profile of <a href="' . htmlspecialchars(url('profile.php?id=' . rawurlencode((string)$usersInfos['id'])), ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($usersInfos['first_name']) . ' ' . htmlspecialchars($usersInfos['last_name']) . '</a> was viewed.');

            }

      }else{
            die(bookfind_translate('You do not have the required permissions to view this profile.'));
      }