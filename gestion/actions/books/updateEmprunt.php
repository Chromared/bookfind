<?php if(isset($_POST['validateUpdate'])){
    if(isset($_POST['date']) AND !empty($_POST['date']) AND isset($_POST['id']) AND !empty($_POST['id']) AND isset($_POST['card']) AND !empty($_POST['card'])){
    
        $date = $_POST['date'];
        $book = $_POST['id'];
        $card = $_POST['card'];

        $updateEmprunt = $bdd->prepare('UPDATE emprunts SET date_futur_retour = ? WHERE id_book = ? AND card_emprunteur = ? AND statut = 1');
        $updateEmprunt->execute(array($date, $book, $card));

        header('emprunt.php?id=' . $book . '&card=' . $card . '');

}}