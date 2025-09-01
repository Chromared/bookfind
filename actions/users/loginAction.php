<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2025 Chromared
?>



<?php
    if (isset($_POST['validate'])) {
    if (isset($_POST['username']) AND isset($_POST['password'])) {
    if (!empty($_POST['username']) AND !empty($_POST['password'])) {

        $username = $_POST['username'];
        $password = $_POST['password'];

        $checkIfUserAlreadyExists = $bdd->prepare('SELECT * FROM users WHERE username = ?');
        $checkIfUserAlreadyExists->execute(array($username));

        if($checkIfUserAlreadyExists->rowCount() > 0){

                $usersInfos = $checkIfUserAlreadyExists->fetch();
            
            if(password_verify($password, $usersInfos['mdp'])){


                
                $_SESSION['auth'] = true;
                $_SESSION['admin'] = false;
                $_SESSION['id'] = $usersInfos['id'];
                $_SESSION['lastname'] = $usersInfos['nom'];
                $_SESSION['firstname'] = $usersInfos['prenom'];
                $_SESSION['username'] = $usersInfos['username'];
                $_SESSION['classe'] = $usersInfos['classe'];
                $_SESSION['grade'] = $usersInfos['grade'];
                $_SESSION['theme'] = $usersInfos['theme'];

                SaveLog($bdd, $_SERVER['REQUEST_URI'], 'Connexion', 'Aucun commentaire.');

                header('Location: index.php');
                

    }else{
        $errorMsg = '<div class="msg"><div class="msg-alerte">Mot de passe est incorrect.</div></div>';
    }}else{
        $errorMsg = '<div class="msg"><div class="msg-alerte">Aucun compte n\'est associé à ce nom d\'utilisateur. Créer mon compte <a href="signup.php">ici</a>.</div></div>';
    }}else{
        $errorMsg = '<div class="msg"><div class="msg-alerte">Tous les champs ne sont pas rempli.</div></div>';
    }}else{
        $errorMsg = '<div class="msg"><div class="msg-alerte"><p>Tous les champs n\'existe pas. Recharger la page en cliquant <a href="login.php">ici</a>.</p></div></div>';
    }
}