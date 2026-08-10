<?php
//This file belongs to the BookFind project.
//
//BookFind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2025 Chromared
?>



<?php require_once __DIR__ . '/../../../actions/functions/sessionInit.php'; if (isset($_POST['validateDelete2'])){
        if($_SESSION['grade'] == 1 OR $_SESSION['grade'] == 2){
            
        $id = $_GET['id'];

        // Retrieve user information before deletion for logging
        $getUser = $bdd->prepare('SELECT id, prenom, nom FROM users WHERE id = ?');
        $getUser->execute(array($id));
        $usersInfos = $getUser->fetch();

        $DeleteUserAccount = $bdd->prepare('DELETE FROM users WHERE id = ?');
        $DeleteUserAccount->execute(array($id));

        SaveLog($bdd, $_SERVER['REQUEST_URI'], 'Suppression de compte', 'Le compte de ' . htmlspecialchars($usersInfos['prenom'] ?? '') . ' ' . htmlspecialchars($usersInfos['nom'] ?? '') . ' a été supprimé.');

        header('Location: users.php');
        
    }else{
        $msg = 'Vous n\'avez pas de permissions suffisentes pour supprimer cet utilisateur.';
    }
}
