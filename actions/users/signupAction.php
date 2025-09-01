<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2025 Chromared
?>



<?php
    if (isset($_POST['validate'])) {
    if (isset($_POST['lastname']) AND isset($_POST['firstname']) AND isset($_POST['password']) AND isset($_POST['confirm_password']) AND isset($_POST['classe'])){
    if (!empty($_POST['lastname']) AND !empty($_POST['firstname']) AND !empty($_POST['password']) AND !empty($_POST['confirm_password']) AND !empty($_POST['classe'])){
 
        if ($_POST['password'] == $_POST['confirm_password']){

            if (isset($_POST['rules-pdc'])){

                $lastname = $_POST['lastname'];
                $firstname = $_POST['firstname'];
                $mdp = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $classe = $_POST['classe'];

                // Generate the username
                $username = strtolower(substr($firstname, 0, 1) . substr($lastname, 0, 7));
                
                // Check if this username already exists in the database
                $stmt = $bdd->prepare("SELECT COUNT(*) FROM users WHERE username LIKE ?");
                $stmt->execute([$username . '%']);
                $count = $stmt->fetchColumn();
                
                // If the username already exists, add a number
                if ($count > 0) {
                    $username .= ($count + 1);  // The number is based on the number of people already having this username
                }

                $checkIfClasseAlreadyExists = $bdd->prepare('SELECT name FROM classes WHERE name = ?');
                $checkIfClasseAlreadyExists->execute(array($classe));

                if($checkIfClasseAlreadyExists->rowCount() > 0){

                    $checkIfOneUserExist = $bdd->query('SELECT id FROM users');

                    if($checkIfOneUserExist->rowCount() == 0){
                        $grade = 1;
                    }else{ $grade = 0; }

                    $insertUserOnWebsite = $bdd->prepare('INSERT INTO users SET username = ?, classe = ?, nom = ?, prenom = ?, mdp = ?, regles = ?, pdc = ?, grade = ?');
                    $insertUserOnWebsite->execute(array($username, $username, $lastname, $firstname, $mdp, true, true, $grade));

                    $getInfosOfThisUserReq = $bdd->prepare('SELECT * FROM users WHERE username = ?');
                    $getInfosOfThisUserReq->execute(array($username));

                    $usersInfos = $getInfosOfThisUserReq->fetch();

                    $_SESSION['auth'] = true;
                    $_SESSION['id'] = $usersInfos['id'];
                    $_SESSION['lastname'] = $usersInfos['nom'];
                    $_SESSION['firstname'] = $usersInfos['prenom'];
                    $_SESSION['username'] = $usersInfos['username'];
                    $_SESSION['classe'] = $usersInfos['classe'];
                    $_SESSION['grade'] = $usersInfos['grade'];
                    $_SESSION['theme'] = $usersInfos['theme'];

                    SaveLog($bdd, $_SERVER['REQUEST_URI'], 'Inscription', 'Aucun commentaire.');

                    header('Location: index.php');

                }else{ $errorMsg = 'La classe sélectionnée n\'existe pas.'; }
            }else{ $errorMsg = 'Les conditions d\'utilisation et les règles doivent être acceptées.'; }
        }else{ $errorMsg = 'Les deux mot de passe ne sont pas identique.'; }
    }else{ $errorMsg = 'Veuillez remplir tous les champs.'; }
}else{ $errorMsg = 'Tous les champs n\'existe pas. Veuillez <a href="signup.php">recharger</a> la page.'; }
}