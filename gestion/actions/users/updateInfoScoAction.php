<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2025 Chromared
?>



<?php if (isset($_POST['validateInfoSco'])) {
    if (isset($_POST['card']) AND isset($_POST['classe'])){
        if (!empty($_POST['card']) AND !empty($_POST['classe'])){
        
            $card = $_POST['card'];
            $classe = $_POST['classe'];
            $id = $_GET['id'];

            $checkIfClasseAlreadyExists = $bdd->prepare('SELECT name FROM classes WHERE name = ?');
            $checkIfClasseAlreadyExists->execute(array($classe));

            if($checkIfClasseAlreadyExists->rowCount() > 0){

                $checkIfCardAlreadyExists = $bdd->prepare('SELECT carte FROM users WHERE carte = ?');
                $checkIfCardAlreadyExists->execute(array($card));

                if ($usersInfos['carte'] == $card OR ($_SESSION['card'] != $card AND $checkIfCardAlreadyExists->rowCount() == 0)){

                    $updateInfoSco = $bdd->prepare('UPDATE users SET carte = ?, classe = ? WHERE id = ?');
                    $updateInfoSco->execute(array($card, $classe, $id));

                    if($card != $usersInfos['carte'] AND $classe == $usersInfos['classe']){
                        SaveLog($bdd, $_SERVER['REQUEST_URI'], 'Modification de compte', 'Le numéro de carte de <a href="../profil.php?id=' . $usersInfos['id'] . '" target="_blank">' . $usersInfos['prenom'] . ' ' . $usersInfos['nom'] . '</a> a été modifié passant de ' . $usersInfos['carte'] . ' à ' . $card . '.');
                    }elseif($card == $usersInfos['carte'] AND $classe != $usersInfos['classe']){
                        SaveLog($bdd, $_SERVER['REQUEST_URI'], 'Modification de compte', 'La classe de <a href="../profil.php?id=' . $usersInfos['id'] . '" target="_blank">' . $usersInfos['prenom'] . ' ' . $usersInfos['nom'] . '</a> a été modifié passant de ' . $usersInfos['classe'] . ' à ' . $classe . '.');
                    }elseif($card != $usersInfos['carte'] AND $classe != $usersInfos['classe']){
                        SaveLog($bdd, $_SERVER['REQUEST_URI'], 'Modification de compte', 'La classe de <a href="../profil.php?id=' . $usersInfos['id'] . '" target="_blank">' . $usersInfos['prenom'] . ' ' . $usersInfos['nom'] . '</a> a été modifié passant de ' . $usersInfos['classe'] . ' à ' . $classe . '. Son numéro de carte à aussi été modifié passant de ' . $usersInfos['carte'] . ' à ' . $card . '.');
                    }
                
                    header('Location: update-user.php?id=' . $id .'');

                }else{ $msg = 'Un compte à déjà été créé avec cette carte.'; }
            }else{ $msg = 'La classe sélectionnée n\'existe pas. Veuillez en choisir une parmi celles proposées.'; }
        }else{ $msg = 'Veuillez remplir tous les champs.'; }
    }else{ $msg = 'Tous les champs n\'existent pas. Veuillez <a href="update-user.php?id=' . $id . '">recharger</a> la page.'; }
}