<?php if(isset($_POST['validate'])){
    if(isset($_POST['card']) AND isset($_POST['date'])){
    if(!empty($_POST['card']) AND !empty($_POST['date'])){

        $book = $_GET['id'];
        $card = $_POST['card'];
        $date = $_POST['date'];

        $checkIfUserAlreadyExists = $bdd->prepare('SELECT carte FROM users WHERE carte = ?');
        $checkIfUserAlreadyExists->execute(array($card));

        $checkIfBookAlreadyExists = $bdd->prepare('SELECT id, titre FROM books WHERE id = ?');
        $checkIfBookAlreadyExists->execute(array($book));
        $booksInfos = $checkIfBookAlreadyExists->fetch();


        $checkIfBookAlreadyAvailable = $bdd->prepare('SELECT statut FROM emprunts WHERE id_book = ?');
        $checkIfBookAlreadyAvailable->execute(array($book));

        if($checkIfUserAlreadyExists->rowCount() > 0){    
        if($checkIfBookAlreadyExists->rowCount() > 0){
        if($checkIfBookAlreadyAvailable !== 1){

        //Pour le statut, 1 = emprunté, 2 = retourné, NULL ou autre = erreur -> à corriger

        $addEmprunt = $bdd->prepare('INSERT INTO emprunts SET id_book = ?, date_retour = ?, card_emprunteur = ?, statut = ?, titre_book = ?');
        $addEmprunt->execute(array($book, $date, $card, 1, $booksInfos['titre']));

        $updateEmpruntForBooks = $bdd->prepare('UPDATE books SET statut = ? WHERE id = ?');
        $updateEmpruntForBooks->execute(array(1, $book));

    }else{$msg = 'Ce livre est déjà emprunté.';}
    }else{$msg = 'Cet id (' . $book . ') ne correspond à aucun livre enregistré.';}
    }else{$msg = 'Ce numéro de carte (' . $card . ') n\'est associé à aucun utilisateur.';}
    }else{$msg = 'Tous les champs ne sont pas remplis.';}
    }else{$msg = 'Tous les champs n\'existent pas.';}
}