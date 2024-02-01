<?php
if (isset($_POST['validateInfoPerso'])) {
        if (isset($_POST['name']) AND isset($_POST['firstname'])) {
        if (!empty($_POST['name']) AND !empty($_POST['firstname'])) {
            $name = htmlspecialchars($_POST['name']);
            $firstname = htmlspecialchars($_POST['firstname']);
            $id = $_SESSION['id'];

            $updateInfoPerso = $bdd->prepare('UPDATE users SET name = ?, firstname = ? WHERE id = ?');
            $updateInfoPerso->execute(array($name, $firstname, $id));
            header('Location: ../index.php');
    }else {
        echo 'Veuillez remplir tous les champs';
    }
}else{
    echo 'Tous les champs n\'existent pas. Veuillez <a href=updateProfil.php>recharger</a> la page.';
}
}
?>