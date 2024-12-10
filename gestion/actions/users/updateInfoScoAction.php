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
        $id = $_GET['id'];

        $checkIfCardAlreadyExists = $bdd->prepare('SELECT carte FROM users WHERE carte = ?');
        $checkIfCardAlreadyExists->execute(array($card));

        if ($usersInfos['carte'] == $card OR ($_SESSION['card'] != $card AND $checkIfCardAlreadyExists->rowCount() == 0)){

        $updateInfoSco = $bdd->prepare('UPDATE users SET carte = ?, classe = ? WHERE id = ?');
        $updateInfoSco->execute(array($card, $classe, $id));

        if($card != $usersInfos['carte'] AND $classe == $usersInfos['classe']){
            SaveLog($bdd, $_SERVER['REQUEST_URI'], 'Modification de compte', 'Modification du numéro de carte. Ancien n° : ' . $usersInfos['carte'] . '. Nouveau n° : ' . $card . '.');
        }elseif($card == $usersInfos['carte'] AND $classe != $usersInfos['classe']){
            SaveLog($bdd, $_SERVER['REQUEST_URI'], 'Modification de compte', 'Modification de la classe. Ancienne classe : ' . $usersInfos['classe'] . '. Nouvelle classe : ' . $classe . '.');
        }elseif($card != $usersInfos['carte'] AND $classe != $usersInfos['classe']){
            SaveLog($bdd, $_SERVER['REQUEST_URI'], 'Modification de compte', 'Modification du numéro de carte. Ancien n° : ' . $usersInfos['carte'] . '. Nouveau n° : ' . $card . '. Modification de la classe. Ancienne classe : ' . $usersInfos['classe'] . '. Nouvelle classe : ' . $classe . '.');
        }

        header('Location: update-user.php?id=' . $id .'');

        }else{
            $Msg = '<div class="msg"><div class="msg-alerte"><p>Un compte à déjà été créé avec cette carte.</p></div></div>';
        }
    }else{
        $Msg = '<div class="msg"><div class="msg-alerte">Veuillez remplir tous les champs.</div></div>';
    }
}else{
    $Msg = '<div class="msg"><div class="msg-alerte">Tous les champs n\'existent pas. Veuillez <a href="update-user.php?id=' . $id . '">recharger</a> la page.</div></div>';
}
}