<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2024 Chromared
?>



<?php if (isset($_POST['validateInfoSco'])) {
    if (isset($_POST['card']) AND isset($_POST['classe'])){
    if (!empty($_POST['card']) AND !empty($_POST['classe'])){
        
        $card = $_POST['card'];
        $classe = $_POST['classe'];
        $id = $_SESSION['id'];

        $checkIfCardAlreadyExists = $bdd->prepare('SELECT carte FROM users WHERE carte = ?');
        $checkIfCardAlreadyExists->execute(array($card));

        if ($_SESSION['card'] == $card OR ($_SESSION['card'] != $card AND $checkIfCardAlreadyExists->rowCount() == 0)){

        $updateInfoSco = $bdd->prepare('UPDATE users SET carte = ?, classe = ? WHERE id = ?');
        $updateInfoSco->execute(array($card, $classe, $id));

        if($card != $_SESSION['card'] AND $classe == $_SESSION['classe']){
            SaveLog($bdd, $_SERVER['REQUEST_URI'], 'Modification de compte', 'Modification du numéro de carte. Ancien n° : ' . $_SESSION['card'] . '. Nouveau n° : ' . $card . '.');
        }elseif($card == $_SESSION['card'] AND $classe != $_SESSION['classe']){
            SaveLog($bdd, $_SERVER['REQUEST_URI'], 'Modification de compte', 'Modification de la classe. Ancienne classe : ' . $_SESSION['classe'] . '. Nouvelle classe : ' . $classe . '.');
        }elseif($card != $_SESSION['card'] AND $classe != $_SESSION['classe']){
            SaveLog($bdd, $_SERVER['REQUEST_URI'], 'Modification de compte', 'Modification du numéro de carte. Ancien n° : ' . $_SESSION['card'] . '. Nouveau n° : ' . $card . '. Modification de la classe. Ancienne classe : ' . $_SESSION['classe'] . '. Nouvelle classe : ' . $classe . '.');
        }

        $_SESSION['card'] = $card;
        $_SESSION['classe'] = $classe;

        header('Location: updateProfil.php?id=' . $id .'&msg=true');

        }else{
            $msg = 'Un compte à déjà été créé avec cette carte.';
        }
    }else{
        $msg = 'Veuillez remplir tous les champs.';
    }
}else{
    $msg = 'Tous les champs n\'existent pas. Veuillez <a href="updateProfil.php?id=' . $id . '">recharger</a> la page.';
}
}