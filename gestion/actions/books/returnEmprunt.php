<?php if(isset($_POST['validate'])){
    if(isset($_POST['id']) AND !empty($_POST['id']) AND isset($_POST['card']) AND !empty($_POST['card'])){

        $book = $_POST['id'];
        $card = $_POST['card'];

        //Pour le statut, 1 = emprunté, 2 = retourné. NULL ou autre = erreur -> à corriger
        $updateEmpruntForBooks = $bdd->prepare('UPDATE books SET statut = ? WHERE id = ?');
        $updateEmpruntForBooks->execute(array(2, $book));

        $updateEmprunt = $bdd->prepare('UPDATE emprunts SET statut = ? WHERE id_book = ?');
        $updateEmprunt->execute(array(2, $book));

        $updateMaxEmpruntUser = $bdd->prepare('UPDATE users SET nb_emprunt_max = ? WHERE carte = ?');
        $updateMaxEmpruntUser->execute(array(-1, $card));

    }
}