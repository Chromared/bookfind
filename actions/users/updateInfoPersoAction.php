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

            if($name != $_SESSION['lastname'] AND $firstname == $_SESSION['firstname']){
                SaveLog($bdd, $_SERVER['REQUEST_URI'], 'Modification de compte', 'Modification du nom de famille. Ancien nom : ' . $_SESSION['lastname'] . '. Nouveau nom : ' . $name . '.');
            }elseif($name == $_SESSION['lastname'] AND $firstname != $_SESSION['firstname']){
                SaveLog($bdd, $_SERVER['REQUEST_URI'], 'Modification de compte', 'Modification du prénom. Ancien prénom : ' . $_SESSION['firstname'] . '. Nouveau prénom : ' . $firstname . '.');
            }elseif($name != $_SESSION['lastname'] AND $firstname != $_SESSION['firstname']){
                SaveLog($bdd, $_SERVER['REQUEST_URI'], 'Modification de compte', 'Modification du prénom et du nom de famille. Ancien prénom : ' . $_SESSION['firstname'] . '. Nouveau prénom : ' . $firstname . '. Ancien nom : ' . $_SESSION['lastname'] . '. Nouveau nom : ' . $name . '.');
            }

            $_SESSION['lastname'] = $name;
            $_SESSION['firstname'] = $firstname;

            header('Location: updateProfil.php?id=' . $id .'&msg=true');

    }else {
        $Msg = '<div class="msg"><div class="msg-alerte">Veuillez remplir tous les champs.</div></div>';
    }
}else{
    $Msg = '<div class="msg"><div class="msg-alerte">Tous les champs n\'existent pas. Veuillez <a href="updateProfil.php?id=' . $id . '">recharger</a> la page.</div></div>';
}
}