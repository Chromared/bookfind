<?php
    if (isset($_POST['name']) AND isset($_POST['firstname']) AND isset($_POST['password']) AND isset($_POST['confirm_password']) AND isset($_POST['card']) AND isset($_POST['classe'])){
        if ($_POST['password'] == $_POST['confirm_password']){

            if (isset($_POST['rules-cu'])){

                $name = $_POST['name'];
                $firstname = $_POST['firstname'];
                $mdp = crypt($_POST['password'], PASSWORD_DEFAULT);
                $card = $_POST['card'];
                $classe = $_POST['classe'];

                $checkIfUserAlreadyExists = $bdd->prepare('SELECT carte FROM users WHERE carte = ?');
                $checkIfUserAlreadyExists->execute(array($card));

                if($checkIfUserAlreadyExists->rowCount() == 0){

                    $insertUserOnWebsite = $bdd->prepare('INSERT INTO users SET card = ?, classe = ?, nom = ?, prenom = ?, mdp = ?');
                    $insertUserOnWebsite->execute(array($card, $classe, $name, $firstname, $mdp));

                    //Récupérer les informations de l'utilisateur
                    $getInfosOfThisUserReq = $bdd->prepare('SELECT id, carte, nom, prenom, grade, classe FROM users WHERE carte = ?');
                    $getInfosOfThisUserReq->execute(array($card));

                    $usersInfos = $getInfosOfThisUserReq->fetch();

                    //Authentifier l'utilisateur sur le site et récupérer ses données dans des variables globales sessions
                    $_SESSION['auth'] = true;
                    $_SESSION['admin'] = false;
                    $_SESSION['id'] = $usersInfos['id'];
                    $_SESSION['lastname'] = $usersInfos['nom'];
                    $_SESSION['firstname'] = $usersInfos['prenom'];
                    $_SESSION['carte'] = $usersInfos['carte'];
                    $_SESSION['classe'] = $usersInfos['classe'];
                    $_SESSION['grade'] = $usersInfos['grade'];

                }else{ ?><p>Un compte à déjà été créé avec cette carte.</p><?php }

            } else { ?><p>Vous devez accepté-e les conditions d'utilisation et les règles.</p><?php }

        }else{ ?><p>Les deux mot de passe ne sont pas identique.</p><?php }

    }
?>