<?php
    if (isset($_POST['validate'])) {
    if (isset($_POST['card']) AND isset($_POST['password'])) {
    if (empty($_POST['card']) AND empty($_POST['password'])) {

        $card = $_POST['card'];
        $password = crypt($_POST['password'], PASSWORD_DEFAULT);

        $checkIfUserAlreadyExists = $bdd->prepare('SELECT carte FROM users WHERE carte = ?');
        $checkIfUserAlreadyExists->execute(array($card));

        if($checkIfUserAlreadyExists->rowCount() == 1){

            $checkIfUserAlreadyExists = $bdd->prepare('SELECT mdp FROM users WHERE carte = ?');
            $checkIfUserAlreadyExists->execute(array($password));

        

    }}}}
?>