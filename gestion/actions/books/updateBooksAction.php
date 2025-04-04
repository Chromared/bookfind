<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2025 Chromared
?>



<?php if(isset($_POST['validate'])){
    if(isset($_GET['id']) AND isset($_POST['title']) AND isset($_POST['author']) AND isset($_POST['isbn']) AND isset($_POST['editeur']) AND isset($_POST['type'])){
        if(!empty($_GET['id']) AND !empty($_POST['title']) AND !empty($_POST['author']) AND !empty($_POST['isbn']) AND !empty($_POST['editeur']) AND !empty($_POST['type'])){

            $id = $_GET['id'];
            $title = $_POST['title'];
            $author = $_POST['author'];
            $isbn = $_POST['isbn'];
            $editeur = $_POST['editeur'];
            $type = $_POST['type'];
            
            if(isset($_POST['resume']) AND !empty($_POST['resume'])){
                $resume = $_POST['resume'];
            }else{$resume = false;}

            if(isset($_POST['genre']) AND !empty($_POST['genre'])){
                $genre = $_POST['genre'];

            }else{$genre = false;}

            if(isset($_POST['id_unique']) AND !empty($_POST['id_unique'])){

                $id_unique = $_POST['id_unique'];

                $checkIfIdUniqueAlreadyExists = $bdd->prepare('SELECT id, id_unique FROM books WHERE id_unique = ?');
                $checkIfIdUniqueAlreadyExists->execute(array($id_unique));
                $idUnique = $checkIfIdUniqueAlreadyExists->fetch();


                if(($checkIfIdUniqueAlreadyExists->rowCount() == 0 AND $id != $idUnique['id']) OR $checkIfIdUniqueAlreadyExists->rowCount() == 1 AND $id == $idUnique['id']){

                	$id_u = true;

                }
            }else{$id_unique = false; $id_u = true;}

            if(isset($_POST['serie']) AND isset($_POST['tome']) AND !empty($_POST['serie']) AND !empty($_POST['tome'])){
                $serie = $_POST['serie'];
                $tome = $_POST['tome'];
            }else{$serie = false; $tome = false;}

            if($id_u = true){

                $addBook = $bdd->prepare('UPDATE books SET titre = ?, auteur = ?, isbn = ?, id_unique = ?, editeur = ?, type = ?, resume = ?, genre = ?, serie = ?, tome = ? WHERE id = ?');
                $addBook->execute(array($title, $author, $isbn, $id_unique, $editeur, $type, $resume, $genre, $serie, $tome, $id));

                $successMsg = 'Livre modifié avec succès';

            }else{ $errorMsg = 'Identifiant unique déjà attribué à un autre livre'; }

        }else{ $errorMsg = 'Tout les champs ne sont pas remplis.'; }
    }else{ $errorMsg = 'Tout les champs n\'existent pas. Veuillez <a href="update-book.php?id=' . $id . '">recharger</a> la page.'; }
}