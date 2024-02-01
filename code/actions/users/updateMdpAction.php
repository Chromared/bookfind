<?php if (isset($_POST['validateMdp'])) {
    if (isset($_POST['actual-password']) AND isset($_POST['new-password']) AND isset($_POST['confirm-new-password'])) {
    if (!empty($_POST['actual-password']) AND !empty($_POST['new-password']) AND !empty($_POST['confirm-new-password'])) {

        if ($_POST[new-password] == $_POST[confirm-new-password]) {
            
        $password = crypt($_POST['actual-password'], PASSWORD_DEFAULT);
        $newPassword = crypt($_POST['new-password'], PASSWORD_DEFAULT);
        $id = $_SESSION['id'];

        $checkPassword = $bdd->prepare('SELECT mdp FROM users WHERE id = ?');
        $checkPassword->execute(array($id));

        if (password_verify($password, $checkPassword['mdp'])) {

            $updateMdp = $bdd->prepare('UPDATE users SET mdp = ? WHERE id = ?');
            $updateMdp->execute(array($newPassword, $id));

    }
}
}
}