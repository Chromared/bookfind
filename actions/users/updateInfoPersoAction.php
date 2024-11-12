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
            $id = $_SESSION['id'];

            $updateInfoPerso = $bdd->prepare('UPDATE users SET nom = ?, prenom = ? WHERE id = ?');
            $updateInfoPerso->execute(array($name, $firstname, $id));

            $_SESSION['name'] = $name;
            $_SESSION['firstname'] = $firstname;

            header('Location: updateProfil.php?id=' . $id .'&msg=true');

    }else {
        $Msg = '<div class="msg"><div class="msg-alerte">Veuillez remplir tous les champs.</div></div>';
    }
}else{
    $Msg = '<div class="msg"><div class="msg-alerte">Tous les champs n\'existent pas. Veuillez <a href="updateProfil.php?id=' . $id . '">recharger</a> la page.</div></div>';
}
}