<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2025 Chromared
?>



<?php if (isset($_POST['validateInfoSco'])) {
    if (isset($_POST['classe'])){
        if (!empty($_POST['classe'])){

            $classe = $_POST['classe'];
            $id = $_SESSION['id'];

            $checkIfClasseAlreadyExists = $bdd->prepare('SELECT name FROM classes WHERE name = ?');
            $checkIfClasseAlreadyExists->execute(array($classe));

            if($checkIfClasseAlreadyExists->rowCount() > 0){
                
                $updateInfoSco = $bdd->prepare('UPDATE users SET classe = ? WHERE id = ?');
                $updateInfoSco->execute(array($classe, $id));

                if($classe != $_SESSION['classe']){
                    SaveLog($bdd, $_SERVER['REQUEST_URI'], 'Modification de compte', 'Modification de la classe. Ancienne classe : ' . $_SESSION['classe'] . '. Nouvelle classe : ' . $classe . '.');
                }

                $_SESSION['classe'] = $classe;

                header('Location: updateProfil.php?id=' . $id .'&msg2=true');

            }else{ $errorMsg2 = 'La classe sélectionnée n\'existe pas.'; }   
        }else{ $errorMsg2 = 'Tous les champs doivent être remplis.'; }
    }else{ $errorMsg2 = 'Tous les champs n\'existent pas. Recharger la page <a href="updateProfil.php?id=' . $id . '">ici</a>.'; }
}