<?php if (isset($_POST['validateMdp'])) {
    if (isset($_POST['actual-password']) AND isset($_POST['new-password']) AND isset($_POST['confirm-new-password'])) {
    if (!empty($_POST['actual-password']) AND !empty($_POST['new-password']) AND !empty($_POST['confirm-new-password'])) {

        if ($_POST['new-password'] == $_POST['confirm-new-password']) {
            
        $password = crypt($_POST['actual-password'], PASSWORD_DEFAULT);
        $newPassword = crypt($_POST['new-password'], PASSWORD_DEFAULT);
        $id = $_GET['id'];

        $checkPassword = $bdd->prepare('SELECT mdp FROM users WHERE id = ?');
        $checkPassword->execute(array($id));

        $checkPassword2 = $checkPassword->fetch();

        if (password_verify($password, $checkPassword2['mdp'])) {

            $updateMdp = $bdd->prepare('UPDATE users SET mdp = ? WHERE id = ?');
            $updateMdp->execute(array($newPassword, $id));

            mysql_close();
            mysql_free_result();

            exit;

    }else{
        $errorMsg = '<div class="msg"><div class="msg-alerte">Votre mot de passe actuel n\'est pas bon.</div></div>';
}
}else{
    $errorMsg = '<div class="msg"><div class="msg-alerte">Les deux nouveaux mot de passe ne sont pas identiques.</div></div>';
}
}else{
    $errorMsg = '<div class="msg"><div class="msg-alerte">Veuillez remplir tous les champs.</div></div>';
}
}else{
    $errorMsg = '<div class="msg"><div class="msg-alerte">Tous les champs n\'existent pas. Veuillez <a href="updateProfil.php">recharger</a> la page.</div></div>';
}
}