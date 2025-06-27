<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2025 Chromared
?>



<?php if (isset($_POST['validateMdp'])) {
    if (isset($_POST['actual-password']) AND isset($_POST['new-password']) AND isset($_POST['confirm-new-password'])) {
    if (!empty($_POST['actual-password']) AND !empty($_POST['new-password']) AND !empty($_POST['confirm-new-password'])) {

        if ($_POST['new-password'] == $_POST['confirm-new-password']) {
            
        $password = $_POST['actual-password'];
        $newPassword = password_hash($_POST['new-password'], PASSWORD_DEFAULT);
        $id = $_SESSION['id'];

        $checkPassword = $bdd->prepare('SELECT mdp FROM users WHERE id = ?');
        $checkPassword->execute(array($id));

        $Password = $checkPassword->fetch();

        if (password_verify($password, $Password['mdp'])) {
            
            $checkPassword->closeCursor();

            $updateMdp = $bdd->prepare('UPDATE users SET mdp = ? WHERE id = ?');
            $updateMdp->execute(array($newPassword, $id));

            SaveLog($bdd, $_SERVER['REQUEST_URI'], 'Modification de compte', 'Modification du mot de passe.');


            header('Location: updateProfil.php?id=' . $id .'&msg3=true');

    }else{
        $errorMsg3 = 'Votre mot de passe actuel n\'est pas bon.';
}
}else{
    $errorMsg3 = 'Les deux nouveaux mot de passe ne sont pas identiques.';
}
}else{
    $errorMsg3 = 'Veuillez remplir tous les champs.';
}
}else{
    $errorMsg3 = 'Tous les champs n\'existent pas. Veuillez <a href="updateProfil.php?id=' . $id . '">recharger</a> la page.';
}
}