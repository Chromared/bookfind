<?php
//This file belongs to the BookFind project.
//Copyright (C) 2026 Chromared
//
//This program is free software: you can redistribute it and/or modify
//it under the terms of the GNU Affero General Public License as
//published by the Free Software Foundation, either version 3 of the
//License, or (at your option) any later version.
//
//This program is distributed in the hope that it will be useful,
//but WITHOUT ANY WARRANTY; without even the implied warranty of
//MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//GNU Affero General Public License for more details.
//
//You should have received a copy of the GNU Affero General Public License
//along with this program.  If not, see <https://www.gnu.org/licenses/>.
?>



<?php require_once __DIR__ . '/../../../actions/functions/sessionInit.php';
$id = $_GET['id'] ?? null;
if(isset($_POST['validate'])){
    if(isset($_GET['id']) AND isset($_POST['title']) AND isset($_POST['author']) AND isset($_POST['isbn']) AND isset($_POST['publisher']) AND isset($_POST['type'])){
        if(!empty($_GET['id']) AND !empty($_POST['title']) AND !empty($_POST['author']) AND !empty($_POST['isbn']) AND !empty($_POST['publisher']) AND !empty($_POST['type'])){

            $id = $_GET['id'];
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

                $checkIfIdUniqueAlreadyExists = $db->prepare('SELECT id, unique_id FROM books WHERE unique_id = ?');
                $checkIfIdUniqueAlreadyExists->execute(array($unique_id));
                $idUnique = $checkIfIdUniqueAlreadyExists->fetch();


                if(($checkIfIdUniqueAlreadyExists->rowCount() == 0 AND $id != $idUnique['id']) OR $checkIfIdUniqueAlreadyExists->rowCount() == 1 AND $id == $idUnique['id']){

                	$id_u = true;

                }
            }else{$unique_id = false; $id_u = true;}

            if(isset($_POST['series']) AND isset($_POST['volume']) AND !empty($_POST['series']) AND !empty($_POST['volume'])){
                $series = $_POST['series'];
                $volume = $_POST['volume'];
            }else{$series = false; $volume = false;}

            if($id_u === true){

                $addBook = $db->prepare('UPDATE books SET title = ?, author = ?, isbn = ?, unique_id = ?, publisher = ?, type = ?, summary = ?, genre = ?, series = ?, volume = ? WHERE id = ?');
                $addBook->execute(array($title, $author, $isbn, $unique_id, $publisher, $type, $summary, $genre, $series, $volume, $id));

                SaveLog($db, $_SERVER['REQUEST_URI'], 'Book modified', 'The book ' . htmlspecialchars($title) . ' was modified successfully.');

                $successMsg = 'Book modified successfully';

            }else{ $errorMsg = bookfind_translate('Unique identifier already assigned to another book'); }
        }else{ $errorMsg = bookfind_translate('Not all fields are filled in.'); }
    }else{ $errorMsg = bookfind_translate('Not all fields exist. Please') . ' <a href="update-book.php?id=' . ($id ?? '') . '">' . bookfind_translate('reload') . '</a> ' . bookfind_translate('the page.'); }
}