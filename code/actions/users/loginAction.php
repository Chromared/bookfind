<?php
    if (isset($_POST['validate'])) {
    if (isset($_POST['card']) AND isset($_POST['password'])) {
    if (empty($_POST['card']) AND empty($_POST['password'])) {

        $card = $_POST['card'];
        $password = crypt($_POST['password'], PASSWORD_DEFAULT);

        $checkIfUserAlreadyExists = $bdd->prepare('SELECT carte FROM users WHERE carte = ?');
        $checkIfUserAlreadyExists->execute(array($card));

        if($checkIfUserAlreadyExists->rowCount() == 1){

            $passwordVerify = $bdd->prepare('SELECT mdp FROM users WHERE carte = ?');
            $passwordVerify->execute(array($password));

            if($password == $passwordVerify){

        

    }else{
        echo "Votre mot de passe est incorrect";
    }}else{
        echo 'Aucun compte n\'est associé à cette carte. Créer mon compte <a href="signup.php?card=' . $card .'">ici</a>.';
    }}}}
?>