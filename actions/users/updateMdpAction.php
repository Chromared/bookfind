# This file belongs to the Bookfind project.
#
# Bookfind is distributed under the terms of the MIT software license.
#
# Copyright (C) 2024 Chromared


<?php if (isset($_POST['validateMdp'])) {
    if (isset($_POST['actual-password']) AND isset($_POST['new-password']) AND isset($_POST['confirm-new-password'])) {
    if (!empty($_POST['actual-password']) AND !empty($_POST['new-password']) AND !empty($_POST['confirm-new-password'])) {

        if ($_POST['new-password'] == $_POST['confirm-new-password']) {
            
        $password = $_POST['actual-password'];
        $newPassword = crypt($_POST['new-password'], PASSWORD_DEFAULT);
        $id = $_SESSION['id'];

        $checkPassword = $bdd->prepare('SELECT mdp FROM users WHERE id = ?');
        $checkPassword->execute(array($id));

        $Password = $checkPassword->fetch();

        if (password_verify($password, $Password['mdp'])) {
            
            $checkPassword->closeCursor();

            $updateMdp = $bdd->prepare('UPDATE users SET mdp = ? WHERE id = ?');
            $updateMdp->execute(array($newPassword, $id));

            header('Location: updateProfil.php?id=' . $id .'&msg=true');

    }else{
        $Msg = '<div class="msg"><div class="msg-alerte">Votre mot de passe actuel n\'est pas bon.</div></div>';
}
}else{
    $Msg = '<div class="msg"><div class="msg-alerte">Les deux nouveaux mot de passe ne sont pas identiques.</div></div>';
}
}else{
    $Msg = '<div class="msg"><div class="msg-alerte">Veuillez remplir tous les champs.</div></div>';
}
}else{
    $Msg = '<div class="msg"><div class="msg-alerte">Tous les champs n\'existent pas. Veuillez <a href="updateProfil.php?id=' . $id . '">recharger</a> la page.</div></div>';
}
}