<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2025 Chromared
?>



<?php if(isset($_POST['validate'])){
    if(isset($_POST['title']) AND isset($_POST['author']) AND isset($_POST['isbn']) AND isset($_POST['editeur']) AND isset($_POST['type'])){
        if(!empty($_POST['title']) AND !empty($_POST['author']) AND !empty($_POST['isbn']) AND !empty($_POST['editeur']) AND !empty($_POST['type'])){

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

                $checkIfIdUniqueAlreadyExists = $bdd->prepare('SELECT id_unique FROM books WHERE id_unique = ?');
                $checkIfIdUniqueAlreadyExists->execute(array($id_unique));

                if($checkIfIdUniqueAlreadyExists->rowCount() == 0){

                $id_u = true;

                }
            }else{$id_unique = false; $id_u = true;}

            if(isset($_POST['serie']) AND isset($_POST['tome']) AND !empty($_POST['serie']) AND !empty($_POST['tome'])){
                $serie = $_POST['serie'];
                $tome = $_POST['tome'];
            }else{$serie = false; $tome = null;}

            if($id_u = true){

                $addBook = $bdd->prepare('INSERT INTO books SET titre = ?, auteur = ?, isbn = ?, id_unique = ?, editeur = ?, type = ?, resume = ?, genre = ?, serie = ?, tome = ?, statut = ?');
                $addBook->execute(array($title, $author, $isbn, $id_unique, $editeur, $type, $resume, $genre, $serie, $tome, 0));

                $successMsg = true;

            }else{ $errorMsg = 'Identifiant unique déjà attribué à un autre livre'; }

        }else{ $errorMsg = 'Tout les champs ne sont pas remplis.'; }
    }else{ $errorMsg = 'Tout les champs n\'existent pas. Veuillez <a href="add-book.php">recharger</a> la page.'; }
}