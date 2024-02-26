<?php if(isset($_POST['validateDelete1'])){
    if(isset($_POST['password'])){
        if(!empty($_POST['password'])){

        $password = htmlspecialchars($_POST['password']);
        $id = $_SESSION['id'];

        $checkPassword = $bdd->prepare('SELECT mdp FROM users WHERE id = ?');
        $checkPassword->execute(array($id));

        $Password = $checkPassword->fetch();

        if (password_verify($password, $Password['mdp'])) {

            $deleteAccount = true;
        
        }else{
            $Msg = '<div class="msg"><div class="msg-alerte">Votre mot de passe actuel n\'est pas bon.</div></div>';
        }

    }else{
        $Msg = '<div class="msg"><div class="msg-alerte">Veuillez remplir tous les champs.</div></div>';
    }
}else{
    $Msg = '<div class="msg"><div class="msg-alerte">Tous les champs n\'existent pas. Veuillez <a href="updateProfil.php?id=' . $id . '">recharger</a> la page.</div></div>';
}
}