<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2024 Chromared
?>



<?php
    if (isset($_POST['validate'])) {
    if (isset($_POST['card']) AND isset($_POST['password'])) {
    if (!empty($_POST['card']) AND !empty($_POST['password'])) {

        $card = $_POST['card'];
        $password = $_POST['password'];

        $checkIfUserAlreadyExists = $bdd->prepare('SELECT * FROM users WHERE carte = ?');
        $checkIfUserAlreadyExists->execute(array($card));

        if($checkIfUserAlreadyExists->rowCount() > 0){

                 //Récupérer les informations de l'utilisateur
                $usersInfos = $checkIfUserAlreadyExists->fetch();
            
            if(password_verify($password, $usersInfos['mdp'])){


                
                //Authentifier l'utilisateur sur le site et récupérer ses données dans des variables globales sessions
                $_SESSION['auth'] = true;
                $_SESSION['admin'] = false;
                $_SESSION['id'] = $usersInfos['id'];
                $_SESSION['lastname'] = $usersInfos['nom'];
                $_SESSION['firstname'] = $usersInfos['prenom'];
                $_SESSION['card'] = $usersInfos['carte'];
                $_SESSION['classe'] = $usersInfos['classe'];
                $_SESSION['grade'] = $usersInfos['grade'];
                $_SESSION['theme'] = $usersInfos['theme'];

                SaveLog($bdd,$_SERVER['REQUEST_URI'], 'Connexion', 'Aucun');
                //Rediriger l'utilisateur vers la page d'accueil
                header('Location: index.php');
                

    }else{
        $errorMsg = '<div class="msg"><div class="msg-alerte">Votre mot de passe est incorrect.</div></div>';
    }}else{
        $errorMsg = '<div class="msg"><div class="msg-alerte">Aucun compte n\'est associé à cette carte. Créer mon compte <a href="signup.php?card=' . $card .'">ici</a>.</div></div>';
    }}else{
        $errorMsg = '<div class="msg"><div class="msg-alerte">Tous les champs ne sont pas rempli.</div></div>';
    }}else{
        $errorMsg = '<div class="msg"><div class="msg-alerte"><p>Tous les champs n\'existe pas. Veuillez <a href="login.php">recharger</a> la page.</p></div></div>';
    }
}