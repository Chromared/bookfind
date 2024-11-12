<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2024 Chromared
?>



<?php if(isset($_POST['validate'])){
    if(isset($_POST['title']) AND isset($_POST['author']) AND isset($_POST['isbn']) AND isset($_POST['editeur']) AND isset($_POST['type'])){
        if(!empty($_POST['title']) AND !empty($_POST['author']) AND !empty($_POST['isbn']) AND !empty($_POST['editeur']) AND !empty($_POST['type'])){

            $title = $_POST['title'];
            $author = $_POST['author'];
            $isbn = $_POST['isbn'];
            $editeur = $_POST['editeur'];
            $type = $_POST['type'];

            if (preg_match('/^([^,]+),\s*(.+)$/', $author, $matches)) {
                $authorname = $matches[1];       // Contient "Riordan"
                $authorfirstname = $matches[2];  // Contient "Rick"       

            $checkAndInsertAuthor = $bdd->prepare('SELECT nomprenom FROM authors WHERE nomprenom = ?');
            $checkAndInsertAuthor->execute(array($author));

            if($checkAndInsertAuthor->rowCount() == 0){

                $addAuthor = $bdd->prepare('INSERT INTO authors SET nom = ?, prenom = ?, nomprenom = ?');
                $addAuthor->execute(array($authorname, $authorfirstname, $author));

            }
            
            $checkAndInsertEditor = $bdd->prepare('SELECT nom FROM editeurs WHERE nom = ?');
            $checkAndInsertEditor->execute(array($editeur));

            if($checkAndInsertEditor->rowCount() == 0){

                $addAuthor = $bdd->prepare('INSERT INTO editeurs SET nom = ?');
                $addAuthor->execute(array($editeur));

            }

            $checkAndInsertType = $bdd->prepare('SELECT nom FROM types WHERE nom = ?');
            $checkAndInsertType->execute(array($type));

            if($checkAndInsertType->rowCount() == 0){

                $addType = $bdd->prepare('INSERT INTO types SET nom = ?');
                $addType->execute(array($type));

            }

            if(isset($_POST['resume']) AND !empty($_POST['resume'])){
                $resume = $_POST['resume'];
            }else{$resume = false;}

            if(isset($_POST['genre']) AND !empty($_POST['genre'])){
                $genre = $_POST['genre'];

                $checkAndInsertGenre = $bdd->prepare('SELECT nom FROM genres WHERE nom = ?');
                $checkAndInsertGenre->execute(array($genre));
    
                if($checkAndInsertGenre->rowCount() == 0){
    
                    $addGenre = $bdd->prepare('INSERT INTO genres SET nom = ?');
                    $addGenre->execute(array($genre));
    
                }
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
            }else{$serie = false; $tome = false;}

            if($id_u = true){

                $addBook = $bdd->prepare('INSERT INTO books SET titre = ?, auteur = ?, isbn = ?, id_unique = ?, editeur = ?, type = ?, resume = ?, genre = ?, serie = ?, tome = ?, statut = ?');
                $addBook->execute(array($title, $author, $isbn, $id_unique, $editeur, $type, $resume, $genre, $serie, $tome, 0));

                header('Location: add-books.php');
            }

        }else {
                $msg = 'Le format de l\'auteur n\'est pas valide.';
            }
        }
    }
}