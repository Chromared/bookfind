<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2025 Chromared
?>



<?php if(isset($_POST['validateReturn'])){
    if(isset($_POST['id']) AND !empty($_POST['id']) AND isset($_POST['user_id']) AND !empty($_POST['user_id'])){

        $book = $_POST['id'];
        $user_id = $_POST['user_id'];

        $selectNbEmpruntsFromUsers = $bdd->prepare('SELECT nb_emprunt FROM users WHERE id = ?');
        $selectNbEmpruntsFromUsers->execute(array($user_id));
        $user_nb_emprunt = $selectNbEmpruntsFromUsers->fetch();

        $nb_emprunt = $user_nb_emprunt['nb_emprunt'] - 1;

        $updateEmpruntForBooks = $bdd->prepare('UPDATE books SET statut = ? WHERE id = ?');
        $updateEmpruntForBooks->execute(array(2, $book));

        $updateEmprunt = $bdd->prepare('UPDATE emprunts SET statut = ?, date_retour = NOW() WHERE id_book = ? AND id_emprunteur = ? AND statut = 1');
        $updateEmprunt->execute(array(2, $book, $user_id));

        $updateMaxEmpruntUser = $bdd->prepare('UPDATE users SET nb_emprunt = ? WHERE id = ?');
        $updateMaxEmpruntUser->execute(array($nb_emprunt, $user_id));

        SaveLog($bdd, $_SERVER['REQUEST_URI'], 'Retour d\'un emprunt', 'Aucun commentaire');

        header('Location: emprunt.php?id=' . $book . '&user_id=' . $user_id);
    }
}