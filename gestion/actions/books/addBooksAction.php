<?php
//This file belongs to the BookFind project.
//
//BookFind is distributed under the terms of the GNU Affero General Public License v3.0.
//
//Copyright (C) 2025 Chromared
?>



<?php require_once __DIR__ . '/../../../actions/functions/sessionInit.php'; if(isset($_POST['validate'])){
    if(isset($_POST['title']) AND isset($_POST['author']) AND isset($_POST['isbn']) AND isset($_POST['publisher']) AND isset($_POST['type'])){
        if(!empty($_POST['title']) AND !empty($_POST['author']) AND !empty($_POST['isbn']) AND !empty($_POST['publisher']) AND !empty($_POST['type'])){

            $title = $_POST['title'];
            $author = $_POST['author'];
            $isbn = $_POST['isbn'];
            $publisher = $_POST['publisher'];
            $type = $_POST['type'];
            
            if(isset($_POST['summary']) AND !empty($_POST['summary'])){
                $summary = $_POST['summary'];
            }else{$summary = false;}

            if(isset($_POST['genre']) AND !empty($_POST['genre'])){
                $genre = $_POST['genre'];

            }else{$genre = false;}

            if(isset($_POST['unique_id']) AND !empty($_POST['unique_id'])){

                $unique_id = $_POST['unique_id'];

                $checkIfIdUniqueAlreadyExists = $db->prepare('SELECT unique_id FROM books WHERE unique_id = ?');
                $checkIfIdUniqueAlreadyExists->execute(array($unique_id));

                if($checkIfIdUniqueAlreadyExists->rowCount() == 0){

                $id_u = true;

                }
            }else{$unique_id = false; $id_u = true;}

            if(isset($_POST['series']) AND isset($_POST['volume']) AND !empty($_POST['series']) AND !empty($_POST['volume'])){
                $series = $_POST['series'];
                $volume = $_POST['volume'];
            }else{$series = false; $volume = null;}

            if($id_u === true){

                $addBook = $db->prepare('INSERT INTO books SET title = ?, author = ?, isbn = ?, unique_id = ?, publisher = ?, type = ?, summary = ?, genre = ?, series = ?, volume = ?, status = ?');
                $addBook->execute(array($title, $author, $isbn, $unique_id, $publisher, $type, $summary, $genre, $series, $volume, 0));

                $successMsg = true;

                SaveLog($db, $_SERVER['REQUEST_URI'], 'Book added', 'The book ' . htmlspecialchars($title) . ' was added successfully.');

            }else{ $errorMsg = 'Unique identifier already assigned to another book'; }

        }else{ $errorMsg = 'Not all fields are filled in.'; }
    }else{ $errorMsg = 'Not all fields exist. Please <a href="add-book.php">reload</a> the page.'; }
}