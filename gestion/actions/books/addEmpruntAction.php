<?php if(isset($_POST['validate'])){
    if(isset($_POST['card']) AND isset($_POST['date'])){
    if(!empty($_POST['card']) AND !empty($_POST['date'])){

        $book = $_GET['id'];
        $card = $_POST['card'];
        $date = $_POST['date'];

        $checkIfUserAlreadyExists = $bdd->prepare('SELECT nb_emprunt_max, nb_emprunt, nom, prenom FROM users WHERE carte = ?');
        $checkIfUserAlreadyExists->execute(array($card));
        $user = $checkIfUserAlreadyExists->fetch();

        $checkIfBookAlreadyExists = $bdd->prepare('SELECT id, titre FROM books WHERE id = ?');
        $checkIfBookAlreadyExists->execute(array($book));
        $booksInfos = $checkIfBookAlreadyExists->fetch();


        $checkIfBookAlreadyAvailable = $bdd->prepare('SELECT statut FROM emprunts WHERE id_book = ? AND statut = ?');
        $checkIfBookAlreadyAvailable->execute(array($book, 0));
        $empruntsInfos = $checkIfBookAlreadyAvailable->fetch();

        if($checkIfUserAlreadyExists->rowCount() > 0){   
        if($checkIfBookAlreadyExists->rowCount() > 0){
        if(NULL){
        if($user['nb_emprunt'] < $user['nb_emprunt_max']){

            $firstname_name = $user['prenom'] . ' ' . $user['nom'];
            
            //Pour le statut, 1 = emprunté, 2 = retourné. NULL ou autre = erreur -> à corriger
            $addEmprunt = $bdd->prepare('INSERT INTO emprunts SET id_book = ?, date_retour = ?, card_emprunteur = ?, firstname_name = ?, statut = ?, titre_book = ?');
            $addEmprunt->execute(array($book, $date, $card, $firstname_name, 1, $booksInfos['titre']));
            
            $updateEmpruntForBooks = $bdd->prepare('UPDATE books SET statut = ? WHERE id = ?');
            $updateEmpruntForBooks->execute(array(1, $book));
            
            $user_nb_emprunt = $user['nb_emprunt'] +1;
            $updateEmpruntForBooks = $bdd->prepare('UPDATE users SET nb_emprunt = ? WHERE carte = ?');
            $updateEmpruntForBooks->execute(array($user_nb_emprunt, $card));
            
    }else{$msg = 'Cet utilisateur a atteint sa limite d\'emprunt.';}
    }else{$msg = 'Ce livre est déjà emprunté.';}
    }else{$msg = 'Cet id (' . $book . ') ne correspond à aucun livre enregistré.';}
    }else{$msg = 'Ce numéro de carte (' . $card . ') n\'est associé à aucun utilisateur.';}
    }else{$msg = 'Tous les champs ne sont pas remplis.';}
    }else{$msg = 'Tous les champs n\'existent pas.';}
}