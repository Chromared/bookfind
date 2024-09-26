<?php
    if (isset($_POST['validate'])) {
    if (isset($_POST['name']) AND isset($_POST['firstname']) AND isset($_POST['password']) AND isset($_POST['confirm_password']) AND isset($_POST['card']) AND isset($_POST['classe'])){
    if (!empty($_POST['name']) AND !empty($_POST['firstname']) AND !empty($_POST['password']) AND !empty($_POST['confirm_password']) AND !empty($_POST['card']) AND !empty($_POST['classe'])){
 
        if ($_POST['password'] == $_POST['confirm_password']){

            if (isset($_POST['rules-pdc'])){

                $name = $_POST['name'];
                $firstname = $_POST['firstname'];
                $mdp = crypt($_POST['password'], PASSWORD_DEFAULT);
                $card = $_POST['card'];
                $classe = $_POST['classe'];

                date_default_timezone_set('Europe/Paris'); 
                $date_j_lettre = date("l");
                $date_j = date("d");
                $date_m = date("m");
                $date_a = date("y");
                $heure_h = date("H");
                $heure_m = date("i");
                $heure_s = date("s");

                $checkIfUserAlreadyExists = $bdd->prepare('SELECT carte FROM users WHERE carte = ?');
                $checkIfUserAlreadyExists->execute(array($card));

                if($checkIfUserAlreadyExists->rowCount() == 0){

                    $insertUserOnWebsite = $bdd->prepare('INSERT INTO users SET carte = ?, classe = ?, nom = ?, prenom = ?, mdp = ?, regles = ?, pdc = ?, date_j_lettre = ?, date_j = ?, date_m = ?, date_a = ?, heure_h = ?, heure_m = ?, heure_s = ?');
                    $insertUserOnWebsite->execute(array($card, $classe, $name, $firstname, $mdp, true, true, $date_j_lettre, $date_j, $date_m, $date_a, $heure_h, $heure_m, $heure_s));

                    //Récupérer les informations de l'utilisateur
                    $getInfosOfThisUserReq = $bdd->prepare('SELECT * FROM users WHERE carte = ?');
                    $getInfosOfThisUserReq->execute(array($card));

                    $usersInfos = $getInfosOfThisUserReq->fetch();

                    //Authentifier l'utilisateur sur le site et récupérer ses données dans des variables globales sessions
                    $_SESSION['auth'] = true;
                    $_SESSION['admin'] = false;
                    $_SESSION['id'] = $usersInfos['id'];
                    $_SESSION['name'] = $usersInfos['nom'];
                    $_SESSION['firstname'] = $usersInfos['prenom'];
                    $_SESSION['card'] = $usersInfos['carte'];
                    $_SESSION['classe'] = $usersInfos['classe'];
                    $_SESSION['grade'] = $usersInfos['grade'];
                    $_SESSION['theme'] = $usersInfos['theme'];
                    
                    header('Location: index.php');

                }else{ $errorMsg = '<div class="msg"><div class="msg-alerte"><p>Un compte à déjà été créé avec cette carte.</p></div></div>'; }

            } else { $errorMsg = '<div class="msg"><div class="msg-alerte"><p>Vous devez accepté-e les conditions d\'utilisation et les règles.</p></div></div>'; }

        }else{ $errorMsg = '<div class="msg"><div class="msg-alerte"><p>Les deux mot de passe ne sont pas identique.</p></div></div>'; }

    }else{ $errorMsg = '<div class="msg"><div class="msg-alerte"><p>Veuillez remplir tous les champs.<p></div></div>'; }
}else{ $errorMsg = '<div class="msg"><div class="msg-alerte"><p>Tous les champs n\'existe pas. Veuillez <a href="signup.php">recharger</a> la page.</p></div></div>'; }
}