<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2024 Chromared
?>



<?php if(isset($_POST['validateReturn'])){
    if(isset($_POST['id']) AND !empty($_POST['id']) AND isset($_POST['card']) AND !empty($_POST['card'])){

        $book = $_POST['id'];
        $card = $_POST['card'];

        //Pour le statut, 1 = emprunté, 2 = retourné. NULL ou autre = erreur -> à corriger
        $updateEmpruntForBooks = $bdd->prepare('UPDATE books SET statut = ? WHERE id = ?');
        $updateEmpruntForBooks->execute(array(2, $book));

        $updateEmprunt = $bdd->prepare('UPDATE emprunts SET statut = ?, date_retour = NOW() WHERE id_book = ? AND card_emprunteur = ? AND statut = 1');
        $updateEmprunt->execute(array(2, $book, $card));

        $updateMaxEmpruntUser = $bdd->prepare('UPDATE users SET nb_emprunt = ? WHERE carte = ?');
        $updateMaxEmpruntUser->execute(array(-1, $card));

        header('Location: emprunt.php?id=' . $book);

    }
}