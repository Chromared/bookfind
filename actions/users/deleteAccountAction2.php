<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2025 Chromared
?>



<?php if (isset($_POST['validateDelete2'])){

        $checkPassword = $bdd->prepare('DELETE FROM users WHERE id = ?');
        $checkPassword->execute(array($id));

        SaveLog($bdd, $_SERVER['REQUEST_URI'], 'Suppression de compte', 'Aucun commentaire.');
        
        header('Location: actions/users/logoutAction.php');
}