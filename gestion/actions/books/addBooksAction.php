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



<?php require_once ROOT_PATH . '/actions/functions/sessionInit.php';
if (isset($_POST['validate'])) {
    if (isset($_POST['title']) and isset($_POST['author']) and isset($_POST['isbn']) and isset($_POST['publisher']) and isset($_POST['type'])) {
        if (!empty($_POST['title']) and !empty($_POST['author']) and !empty($_POST['isbn']) and !empty($_POST['publisher']) and !empty($_POST['type'])) {

            $title = $_POST['title'];
            $author = $_POST['author'];
            $isbn = $_POST['isbn'];
            $publisher = $_POST['publisher'];
            $type = $_POST['type'];

            if (isset($_POST['summary']) and !empty($_POST['summary'])) {
                $summary = $_POST['summary'];
            } else {
                $summary = false;
            }

            if (isset($_POST['genre']) and !empty($_POST['genre'])) {
                $genre = $_POST['genre'];
            } else {
                $genre = false;
            }

            if (isset($_POST['unique_id']) and !empty($_POST['unique_id'])) {

                $unique_id = $_POST['unique_id'];

                $checkIfIdUniqueAlreadyExists = $db->prepare('SELECT unique_id FROM books WHERE unique_id = ?');
                $checkIfIdUniqueAlreadyExists->execute(array($unique_id));

                if ($checkIfIdUniqueAlreadyExists->rowCount() == 0) {

                    $id_u = true;
                }
            } else {
                $unique_id = false;
                $id_u = true;
            }

            if (isset($_POST['series']) and isset($_POST['volume']) and !empty($_POST['series']) and !empty($_POST['volume'])) {
                $series = $_POST['series'];
                $volume = $_POST['volume'];
            } else {
                $series = false;
                $volume = null;
            }

            if ($id_u === true) {

                $addBook = $db->prepare('INSERT INTO books SET title = ?, author = ?, isbn = ?, unique_id = ?, publisher = ?, type = ?, summary = ?, genre = ?, series = ?, volume = ?, status = ?');
                $addBook->execute(array($title, $author, $isbn, $unique_id, $publisher, $type, $summary, $genre, $series, $volume, 0));

                $successMsg = true;

                SaveLog($db, $_SERVER['REQUEST_URI'], 'Book added', 'The book ' . htmlspecialchars($title) . ' was added successfully.');
            } else {
                $errorMsg = bookfind_translate('Unique identifier already assigned to another book');
            }
        } else {
            $errorMsg = bookfind_translate('Not all fields are filled in.');
        }
    } else {
        $errorMsg = bookfind_translate('Not all fields exist. Please') . ' <a href="' . htmlspecialchars(url('gestion/add-book.php'), ENT_QUOTES, 'UTF-8') . '">' . bookfind_translate('reload') . '</a> ' . bookfind_translate('the page.');
    }
}
