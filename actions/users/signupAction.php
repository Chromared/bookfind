<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2025 Chromared
?>



<?php
    if (isset($_POST['validate'])) {
    if (isset($_POST['name']) AND isset($_POST['firstname']) AND isset($_POST['password']) AND isset($_POST['confirm_password']) AND isset($_POST['card']) AND isset($_POST['classe'])){
    if (!empty($_POST['name']) AND !empty($_POST['firstname']) AND !empty($_POST['password']) AND !empty($_POST['confirm_password']) AND !empty($_POST['card']) AND !empty($_POST['classe'])){
 
        if ($_POST['password'] == $_POST['confirm_password']){

            if (isset($_POST['rules-pdc'])){

                $name = $_POST['name'];
                $firstname = $_POST['firstname'];
                $mdp = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $card = $_POST['card'];
                $classe = $_POST['classe'];

                $checkIfClasseAlreadyExists = $bdd->prepare('SELECT name FROM classes WHERE name = ?');
                $checkIfClasseAlreadyExists->execute(array($classe));

                if($checkIfClasseAlreadyExists->rowCount() > 0){

                    $checkIfUserAlreadyExists = $bdd->prepare('SELECT carte FROM users WHERE carte = ?');
                    $checkIfUserAlreadyExists->execute(array($card));

                    if($checkIfUserAlreadyExists->rowCount() == 0){

                        $checkIfOneUserExist = $bdd->query('SELECT id FROM users');

                        if($checkIfOneUserExist->rowCount() == 0){
                            $grade = 1;
                        }else{ $grade = 0; }

                        $insertUserOnWebsite = $bdd->prepare('INSERT INTO users SET carte = ?, classe = ?, nom = ?, prenom = ?, mdp = ?, regles = ?, pdc = ?, grade = ?');
                        $insertUserOnWebsite->execute(array($card, $classe, $name, $firstname, $mdp, true, true, $grade));

                        $getInfosOfThisUserReq = $bdd->prepare('SELECT * FROM users WHERE carte = ?');
                        $getInfosOfThisUserReq->execute(array($card));

                        $usersInfos = $getInfosOfThisUserReq->fetch();

                        $_SESSION['auth'] = true;
                        $_SESSION['id'] = $usersInfos['id'];
                        $_SESSION['lastname'] = $usersInfos['nom'];
                        $_SESSION['firstname'] = $usersInfos['prenom'];
                        $_SESSION['card'] = $usersInfos['carte'];
                        $_SESSION['classe'] = $usersInfos['classe'];
                        $_SESSION['grade'] = $usersInfos['grade'];
                        $_SESSION['theme'] = $usersInfos['theme'];

                        SaveLog($bdd, $_SERVER['REQUEST_URI'], 'Inscription', 'Aucun commentaire.');

                        header('Location: index.php');

                    }else{ $errorMsg = 'Un compte à déjà été créé avec cette carte.'; }
                }else{ $errorMsg = 'La classe sélectionnée n\'existe pas. Veuillez en choisir une parmi celles proposées.'; }
            }else{ $errorMsg = 'Vous devez accepté-e les conditions d\'utilisation et les règles.'; }
        }else{ $errorMsg = 'Les deux mot de passe ne sont pas identique.'; }
    }else{ $errorMsg = 'Veuillez remplir tous les champs.'; }
}else{ $errorMsg = 'Tous les champs n\'existe pas. Veuillez <a href="signup.php">recharger</a> la page.'; }
}