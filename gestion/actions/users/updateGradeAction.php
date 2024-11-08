# This file belongs to the Bookfind project.
#
# Bookfind is distributed under the terms of the MIT software license.
#
# Copyright (C) 2024 Chromared


<?php if (isset($_POST['validateGrade'])) {
    if (isset($_POST['grade'])){
        if (!empty($_POST['grade']) OR $_POST['grade'] == '0'){
    
            $grade = $_POST['grade'];
            $id = $_GET['id'];

            $updateInfoSco = $bdd->prepare('UPDATE users SET grade = ? WHERE id = ?');
            $updateInfoSco->execute(array($grade, $id));
    
            header('Location: update-user.php?id=' . $id .'');

        }else{
            $Msg = '<div class="msg"><div class="msg-alerte">Veuillez remplir tous les champs.</div></div>';
        }
    }else{
        $Msg = '<div class="msg"><div class="msg-alerte">Tous les champs n\'existent pas. Veuillez <a href="update-user.php?id=' . $id . '">recharger</a> la page.</div></div>';
    }
    }