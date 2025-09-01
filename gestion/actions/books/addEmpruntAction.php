<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2025 Chromared
?>



<?php if(isset($_POST['validateAdd'])){
    if(isset($_POST['user_id']) AND isset($_POST['date'])){
    if(!empty($_POST['user_id']) AND !empty($_POST['date'])){

        $book = $_GET['id'];
        $user_id = $_POST['user_id'];
        $date = $_POST['date'];

        $checkIfUserAlreadyExists = $bdd->prepare('SELECT * FROM users WHERE id = ?');
        $checkIfUserAlreadyExists->execute(array($user_id));
        $user = $checkIfUserAlreadyExists->fetch();

        if($checkIfUserAlreadyExists->rowCount() > 0){
        if($booksInfos['statut'] != 1){
        if($user['nb_emprunt'] < $user['nb_emprunt_max']){

            $firstname_name = $user['prenom'] . ' ' . $user['nom'];
            
            $addEmprunt = $bdd->prepare('INSERT INTO emprunts SET id_book = ?, date_futur_retour = ?, id_emprunteur = ?, firstname_name = ?, statut = ?, titre_book = ?');
            $addEmprunt->execute(array($book, $date, $user_id, $firstname_name, 1, $booksInfos['titre']));

            $updateEmpruntForBooks = $bdd->prepare('UPDATE books SET statut = ? WHERE id = ?');
            $updateEmpruntForBooks->execute(array(1, $book));
            
            $user_nb_emprunt = $user['nb_emprunt'] + 1;
            $updateUser = $bdd->prepare('UPDATE users SET nb_emprunt = ? WHERE id = ?');
            $updateUser->execute(array($user_nb_emprunt, $user_id));

            SaveLog($bdd, $_SERVER['REQUEST_URI'], 'Emprunt d\'un livre', 'Le livre ' . htmlspecialchars($booksInfos['titre']) . ' a été emprunté.');

            header('Location: emprunt.php?id=' . $book . '&user_id=' . $user_id);

    }else{$msg1 = 'Cet utilisateur a atteint sa limite d\'emprunt.';}
    }else{$msg1 = 'Ce livre est déjà emprunté.';}
    }else{$msg1 = 'Cet utilisateur n\'existe pas.';}
    }else{$msg1 = 'Tous les champs ne sont pas remplis.';}
    }else{$msg1 = 'Tous les champs n\'existent pas.';}
}