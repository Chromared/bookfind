<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2024 Chromared
?>



<?php if(isset($_POST['validateAdd'])){
    if(isset($_POST['card']) AND isset($_POST['date'])){
    if(!empty($_POST['card']) AND !empty($_POST['date'])){

        $book = $_GET['id'];
        $card = $_POST['card'];
        $date = $_POST['date'];

        $checkIfUserAlreadyExists = $bdd->prepare('SELECT * FROM users WHERE carte = ?');
        $checkIfUserAlreadyExists->execute(array($card));
        $user = $checkIfUserAlreadyExists->fetch();

        if($checkIfUserAlreadyExists->rowCount() > 0){
        if($booksInfos['statut'] != 1){
        if($user['nb_emprunt'] < $user['nb_emprunt_max']){

            $firstname_name = $user['prenom'] . ' ' . $user['nom'];
            
            $addEmprunt = $bdd->prepare('INSERT INTO emprunts SET id_book = ?, date_futur_retour = ?, card_emprunteur = ?, firstname_name = ?, statut = ?, titre_book = ?');
            $addEmprunt->execute(array($book, $date, $card, $firstname_name, 1, $booksInfos['titre']));
            
            $updateEmpruntForBooks = $bdd->prepare('UPDATE books SET statut = ? WHERE id = ?');
            $updateEmpruntForBooks->execute(array(1, $book));
            
            $user_nb_emprunt = $user['nb_emprunt'] + 1;
            $updateUser = $bdd->prepare('UPDATE users SET nb_emprunt = ? WHERE carte = ?');
            $updateUser->execute(array($user_nb_emprunt, $card));

            header('Location: emprunt.php?id=' . $book . '&card=' . $card);
            
    }else{$msg = 'Cet utilisateur a atteint sa limite d\'emprunt.';}
    }else{$msg = 'Ce livre est déjà emprunté.';}
    }else{$msg = 'Ce numéro de carte (' . $card . ') n\'est associé à aucun utilisateur.';}
    }else{$msg = 'Tous les champs ne sont pas remplis.';}
    }else{$msg = 'Tous les champs n\'existent pas.';}
}