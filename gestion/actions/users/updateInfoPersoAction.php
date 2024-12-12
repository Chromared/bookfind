<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2024 Chromared
?>



<?php
if (isset($_POST['validateInfoPerso'])) {
        if (isset($_POST['name']) AND isset($_POST['firstname'])) {
        if (!empty($_POST['name']) AND !empty($_POST['firstname'])) {
            $name = $_POST['name'];
            $firstname = $_POST['firstname'];
            $id = $_GET['id'];

            $updateInfoPerso = $bdd->prepare('UPDATE users SET nom = ?, prenom = ? WHERE id = ?');
            $updateInfoPerso->execute(array($name, $firstname, $id));

            if($name != $usersInfos['nom'] AND $firstname == $usersInfos['prenom']){
                SaveLog($bdd, $_SERVER['REQUEST_URI'], 'Modification de compte', 'Modification du nom de famille. Ancien nom : ' . $usersInfos['nom'] . '. Nouveau nom : ' . $name . '.');
            }elseif($name == $usersInfos['nom'] AND $firstname != $usersInfos['prenom']){
                SaveLog($bdd, $_SERVER['REQUEST_URI'], 'Modification de compte', 'Modification du prénom. Ancien prénom : ' . $usersInfos['prenom'] . '. Nouveau prénom : ' . $firstname . '.');
            }elseif($name != $usersInfos['nom'] AND $firstname != $usersInfos['prenom']){
                SaveLog($bdd, $_SERVER['REQUEST_URI'], 'Modification de compte', 'Modification du prénom et du nom de famille. Ancien prénom : ' . $usersInfos['prenom'] . '. Nouveau prénom : ' . $firstname . '. Ancien nom : ' . $usersInfos['nom'] . '. Nouveau nom : ' . $name . '.');
            }

            header('Location: update-user.php?id=' . $id .'');

    }else {
        $msg = 'Veuillez remplir tous les champs.';
    }
}else{
    $msg = 'Tous les champs n\'existent pas. Veuillez <a href="update-user.php?id=' . $id . '">recharger</a> la page.';
}
}