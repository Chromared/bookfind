<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2025 Chromared
?>



<?php if (isset($_POST['validateInfoSco'])) {
    if (isset($_POST['classe'])){
        if (!empty(!empty($_POST['classe']))){

            $classe = $_POST['classe'];
            $id = $_GET['id'];

            $checkIfClasseAlreadyExists = $bdd->prepare('SELECT name FROM classes WHERE name = ?');
            $checkIfClasseAlreadyExists->execute(array($classe));

            if($checkIfClasseAlreadyExists->rowCount() > 0){

                $updateInfoSco = $bdd->prepare('UPDATE users SET classe = ? WHERE id = ?');
                $updateInfoSco->execute(array($classe, $id));

                if($classe != $usersInfos['classe']){
                    SaveLog($bdd, $_SERVER['REQUEST_URI'], 'Modification de compte', 'La classe de <a href="../profil.php?id=' . $usersInfos['id'] . '">' . $usersInfos['prenom'] . ' ' . $usersInfos['nom'] . '</a> a été modifié passant de ' . $usersInfos['classe'] . ' à ' . $classe . '.');
                }
            
                header('Location: update-user.php?id=' . $id .'&msg2=true');

            }else{ $errorMsg2 = 'La classe sélectionnée n\'existe pas.'; }
        }else{ $errorMsg2 = 'Tous les champs doivent être remplis.'; }
    }else{ $errorMsg2 = 'Tous les champs n\'existent pas. Recharger la page <a href="update-user.php?id=' . $id . '">ici</a>.'; }
}