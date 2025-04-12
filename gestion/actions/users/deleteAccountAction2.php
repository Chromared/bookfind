<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2025 Chromared
?>



<?php if (isset($_POST['validateDelete2'])){
        if($_SESSION['grade'] == 1 OR $_SESSION['grade'] == 2){
            
        $id = $_GET['id'];

        $DeleteUserAccount = $bdd->prepare('DELETE FROM users WHERE id = ?');
        $DeleteUserAccount->execute(array($id));

        SaveLog($bdd, $_SERVER['REQUEST_URI'], 'Suppression de compte', 'Le compte de ' . $usersInfos['prenom'] . ' ' . $usersInfos['nom'] . ' a été supprimé.');

        header('Location: users.php');
        
    }else{
        $msg = 'Vous n\'avez pas de permissions suffisentes pour supprimer cet utilisateur.';
    }
}}
