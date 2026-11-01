<?php
//This file belongs to the BookFind project.
//
//BookFind is distributed under the terms of the GNU Affero General Public License v3.0.
//
//Copyright (C) 2025 Chromared
?>



<?php $id = htmlspecialchars($_GET['id']);

      if($id == $_SESSION['id'] OR $_SESSION['grade'] !== 0){       

            $selectInfosFromUsers = $db->prepare('SELECT * FROM users WHERE id = ?');
            $selectInfosFromUsers->execute(array($id));

            $usersInfos = $selectInfosFromUsers->fetch();

            if($id != $_SESSION['id'] AND $selectInfosFromUsers->rowCount() === 1){

                  SaveLog($db, $_SERVER['REQUEST_URI'], 'Profile viewed', 'The profile of <a href="../profile.php?id=' . htmlspecialchars($usersInfos['id']) . '">' . htmlspecialchars($usersInfos['first_name']) . ' ' . htmlspecialchars($usersInfos['last_name']) . '</a> was viewed.');

            }

      }else{
            die('You do not have the required permissions to view this profile.');
      }