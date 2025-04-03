<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2025 Chromared
?>



<?php if(isset($_POST['validateDelete1'])){
    if(isset($_POST['password'])){
        if(!empty($_POST['password'])){

        $password = $_POST['password'];
        $id = $_SESSION['id'];

        $checkPassword = $bdd->prepare('SELECT mdp, nb_emprunt FROM users WHERE id = ?');
        $checkPassword->execute(array($id));

        $InfoDelete = $checkPassword->fetch();

        if($InfoDelete['nb_emprunt'] == '0'){

        if (password_verify($password, $InfoDelete['mdp'])) {

            $deleteAccount = true;
        
        }else{
            $errorMsg4 = 'Votre mot de passe actuel n\'est pas bon.';
        }

    }else{
        $errorMsg4 = 'Vous devez avoir rendu tous vos emprunts pour supprimer votre compte. Il vous reste actuellement ' . $InfoDelete['nb_emprunt'] . ' livre(s) emprunté(s).';
    }

    }else{
        $errorMsg4 = 'Veuillez remplir tous les champs.';
    }
}else{
    $errorMsg4 = 'Tous les champs n\'existent pas. Veuillez <a href="updateProfil.php?id=' . $id . '">recharger</a> la page.';
}
}