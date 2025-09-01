<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2025 Chromared
?>



<?php $id = htmlspecialchars($_GET['id']);

      if($id == $_SESSION['id'] OR $_SESSION['grade'] !== 0){       

            $selectInfosFromUsers = $bdd->prepare('SELECT * FROM users WHERE id = ?');
            $selectInfosFromUsers->execute(array($id));

            $usersInfos = $selectInfosFromUsers->fetch();

            if($id != $_SESSION['id'] AND $selectInfosFromUsers->rowCount() === 1){

                  SaveLog($bdd, $_SERVER['REQUEST_URI'], 'Consultation de profil', 'Le profil de <a href="../profil.php?id=' . htmlspecialchars($usersInfos['id']) . '">' . htmlspecialchars($usersInfos['prenom']) . ' ' . htmlspecialchars($usersInfos['nom']) . '</a> a été consulté.');

            }

      }else{
            die('Vous n\'avez pas les permissions nécessaires pour accéder à ce profil.');
      }