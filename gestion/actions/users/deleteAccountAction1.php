# X11 License
# 2024 Chromared


<?php if(isset($_POST['validateDelete1'])){

        $id = $_SESSION['id'];

        $checkPassword = $bdd->prepare('SELECT nb_emprunt FROM users WHERE id = ?');
        $checkPassword->execute(array($id));

        $InfoDelete = $checkPassword->fetch();

        if($InfoDelete['nb_emprunt'] == '0'){

            $deleteAccount = true;

    }else{
        $Msg = '<div class="msg"><div class="msg-alerte">Vous devez avoir rendu tous vos emprunts pour supprimer votre compte. Il vous reste actuellement ' . $InfoDelete['nb_emprunt'] . ' livre(s) emprunté(s).</div></div>';
    }
}