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
                SaveLog($bdd, $_SERVER['REQUEST_URI'], 'Modification de compte', 'Le nouveau nom est ' . $name . '.');
            }elseif($name == $_SESSION['lastname'] AND $firstname != $_SESSION['firstname']){
                SaveLog($bdd, $_SERVER['REQUEST_URI'], 'Modification de compte', 'Le nouveau prénom est ' . $firstname . '.');
            }elseif($name != $_SESSION['lastname'] AND $firstname != $_SESSION['firstname']){
                SaveLog($bdd, $_SERVER['REQUEST_URI'], 'Modification de compte', 'Cette utilisateur se nomme maintenant ' . $name . ' ' . $firstname . '.');
            }

            $_SESSION['lastname'] = $name;
            $_SESSION['firstname'] = $firstname;

            header('Location: updateProfil.php?id=' . $id .'&msg=true');

    }else {
        $msg = 'Veuillez remplir tous les champs.';
    }
}else{
    $msg = 'Tous les champs n\'existent pas. Veuillez <a href="updateProfil.php?id=' . $id . '">recharger</a> la page.';
}
}