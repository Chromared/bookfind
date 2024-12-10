<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2024 Chromared
?>



<?php if (isset($_POST['validateDelete2'])){
    if(isset($_POST['confirm-delete'])){
    if(!empty($_POST['confirm-delete'])){
        if($_SESSION['grade'] == 1 OR $_SESSION['grade'] == 2){
            
        $id = $_GET['id'];

        $DeleteUserAccount = $bdd->prepare('DELETE FROM users WHERE id = ?');
        $DeleteUserAccount->execute(array($id));

        SaveLog($bdd, $_SERVER['REQUEST_URI'], 'Suppression de compte', 'Le compte de ' . $usersInfos['prenom'] . ' ' . $usersInfos['nom'] . ' (' . $usersInfos['carte'] . ') à été supprimé.');

        header('Location: users.php');
        
    }else{
        $Msg = 'Vous n\'avez pas de permissions suffisentes pour appliquer ce grade.';
    }
}
}
}