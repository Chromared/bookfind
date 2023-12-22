<?php
    if (isset($_POST['validate'])) {
    if (isset($_POST['card']) AND isset($_POST['password'])) {
    if (empty($_POST['card']) AND empty($_POST['password'])) {

        $card = htmlspecialchars($_POST['card']);
        $password = crypt($_POST['password'], PASSWORD_DEFAULT);

        $checkIfUserAlreadyExists = $bdd->prepare('SELECT carte FROM users WHERE carte = ?');
        $checkIfUserAlreadyExists->execute(array($card));

        if($checkIfUserAlreadyExists->rowCount() == 1){

            $passwordVerify = $bdd->prepare('SELECT mdp FROM users WHERE carte = ?');
            $passwordVerify->execute(array($password));

            if($password == $passwordVerify){

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
                


        

    }else{
        echo 'Votre mot de passe est incorrect';
    }}else{
        echo 'Aucun compte n\'est associé à cette carte. Créer mon compte <a href="signup.php?card=' . $card .'">ici</a>.';
    }}}}
?>