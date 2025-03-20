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
                SaveLog($bdd, $_SERVER['REQUEST_URI'], 'Modification de compte', 'Modification du nom de famille de <a href="../profil.php?id=' . $usersInfos['id'] . '" target="_blank">' . $usersInfos['prenom'] . ' ' . $usersInfos['nom'] . '</a> passant de ' . $usersInfos['nom'] . ' à ' . $name . '.');
            }elseif($name == $usersInfos['nom'] AND $firstname != $usersInfos['prenom']){
                SaveLog($bdd, $_SERVER['REQUEST_URI'], 'Modification de compte', 'Modification du nom de prénom de <a href="../profil.php?id=' . $usersInfos['id'] . '" target="_blank">' . $usersInfos['prenom'] . ' ' . $usersInfos['nom'] . '</a> passant de ' . $usersInfos['prenom'] . ' à ' . $firstname . '.');
            }elseif($name != $usersInfos['nom'] AND $firstname != $usersInfos['prenom']){
                SaveLog($bdd, $_SERVER['REQUEST_URI'], 'Modification de compte', 'Modification du prénom et du nom de famille de <a href="../profil.php?id=' . $usersInfos['id'] . '" target="_blank">' . $usersInfos['prenom'] . ' ' . $usersInfos['nom'] . '</a>. Son ancien prénom était ' . $usersInfos['prenom'] . ' et est maintenant ' . $firstname . '. Quant à son nom, il passe de ' . $usersInfos['nom'] . ' à ' . $name . '.');
            }

            header('Location: update-user.php?id=' . $id .'');

    }else {
        $msg = 'Veuillez remplir tous les champs.';
    }
}else{
    $msg = 'Tous les champs n\'existent pas. Veuillez <a href="update-user.php?id=' . $id . '">recharger</a> la page.';
}
}