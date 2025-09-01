<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2025 Chromared
?>



<?php if(isset($_POST['validateUpdate'])){
    if(isset($_POST['date']) AND !empty($_POST['date']) AND isset($_POST['id']) AND !empty($_POST['id']) AND isset($_POST['user_id']) AND !empty($_POST['user_id'])){

        $date = $_POST['date'];
        $book = $_POST['id'];
        $user = $_POST['user_id'];

        $updateEmprunt = $bdd->prepare('UPDATE emprunts SET date_futur_retour = ? WHERE id_book = ? AND id_emprunteur = ? AND statut = 1');
        $updateEmprunt->execute(array($date, $book, $user));

        header('Location: emprunt.php?id=' . $book . '&user_id=' . $user . '&success');

}}