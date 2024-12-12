<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2024 Chromared
?>



<?php if (isset($_POST['validateGrade'])) {
    if (isset($_POST['grade'])){
        if (!empty($_POST['grade']) OR $_POST['grade'] != '0'){

            if(($_POST['grade'] == 1 AND $_SESSION['grade'] == 1) OR $_POST['grade'] != 1){
    
            $newGrade = $_POST['grade'];
            $id = $_GET['id'];

            $updateInfoSco = $bdd->prepare('UPDATE users SET grade = ? WHERE id = ?');
            $updateInfoSco->execute(array($newGrade, $id));

            SaveLog($bdd, $_SERVER['REQUEST_URI'], 'Modification de grade', 'Le grade de ' . $usersInfos['prenom'] . ' ' . $usersInfos['nom'] . ' (' . $usersInfos['carte'] . ') à été changé de ' . NoEchoGrade($usersInfos['grade']) . ' vers ' . NoEchoGrade($newGrade) . '.');
    
            header('Location: update-user.php?id=' . $id);
            }else{
                $msg = 'Vous n\'avez pas de permissions suffisentes pour appliquer ce grade.';
            }
        }else{
            $msg = 'Veuillez remplir tous les champs.';
        }
    }else{
        $msg = 'Tous les champs n\'existent pas. Veuillez <a href="update-user.php?id=' . $id . '">recharger</a> la page.';
    }
    }