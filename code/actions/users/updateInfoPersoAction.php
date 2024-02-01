<?php
if (isset($_POST['validateInfoPerso'])) {
        if (isset($_POST['name']) AND isset($_POST['firstname'])) {
        if (!empty($_POST['name']) AND !empty($_POST['firstname'])) {
            $name = htmlspecialchars($_POST['name']);
            $firstname = htmlspecialchars($_POST['firstname']);
            $id = $_SESSION['id'];

            $updateInfoPerso = $bdd->prepare('UPDATE users SET nom = ?, prenom = ? WHERE id = ?');
            $updateInfoPerso->execute(array($name, $firstname, $id));
            header('Location: updateProfil.php.php');
    }else {
        $errorMsg = '<div class="msg"><div class="msg-alerte">Veuillez remplir tous les champs.</div></div>';
    }
}else{
    $errorMsg = '<div class="msg"><div class="msg-alerte">Tous les champs n\'existent pas. Veuillez <a href="updateProfil.php">recharger</a> la page.</div></div>';
}
}
?>