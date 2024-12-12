<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2024 Chromared
?>



<?php if (isset($_POST['validateMdp'])) {
    if (isset($_POST['new-password']) AND isset($_POST['confirm-new-password'])) {
    if (!empty($_POST['new-password']) AND !empty($_POST['confirm-new-password'])) {

        if ($_POST['new-password'] == $_POST['confirm-new-password']) {

        $newPassword = crypt($_POST['new-password'], PASSWORD_DEFAULT);
        $id = $_GET['id'];

            $updateMdp = $bdd->prepare('UPDATE users SET mdp = ? WHERE id = ?');
            $updateMdp->execute(array($newPassword, $id));

            SaveLog($bdd, $_SERVER['REQUEST_URI'], 'Modification de mot de passe', 'Le mot de passe de ' . $usersInfos['prenom'] . ' ' . $usersInfos['nom'] . ' (' . $usersInfos['carte'] . ') à été changé.');

            header('Location: update-user.php?id=' . $id .'');

}else{
    $msg = 'Les deux nouveaux mot de passe ne sont pas identiques.';
}
}else{
    $msg = 'Veuillez remplir tous les champs.';
}
}else{
    $msg = 'Tous les champs n\'existent pas. Veuillez <a href="update-user.php?id=' . $id . '">recharger</a> la page.';
}
}