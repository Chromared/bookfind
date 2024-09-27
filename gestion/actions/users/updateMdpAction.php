<?php if (isset($_POST['validateMdp'])) {
    if (isset($_POST['new-password']) AND isset($_POST['confirm-new-password'])) {
    if (!empty($_POST['new-password']) AND !empty($_POST['confirm-new-password'])) {

        if ($_POST['new-password'] == $_POST['confirm-new-password']) {

        $newPassword = crypt($_POST['new-password'], PASSWORD_DEFAULT);
        $id = $_GET['id'];

            $updateMdp = $bdd->prepare('UPDATE users SET mdp = ? WHERE id = ?');
            $updateMdp->execute(array($newPassword, $id));

            header('Location: update-user.php?id=' . $id .'');

}else{
    $Msg = '<div class="msg"><div class="msg-alerte">Les deux nouveaux mot de passe ne sont pas identiques.</div></div>';
}
}else{
    $Msg = '<div class="msg"><div class="msg-alerte">Veuillez remplir tous les champs.</div></div>';
}
}else{
    $Msg = '<div class="msg"><div class="msg-alerte">Tous les champs n\'existent pas. Veuillez <a href="update-user.php?id=' . $id . '">recharger</a> la page.</div></div>';
}
}