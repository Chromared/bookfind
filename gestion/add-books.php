<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2024 Chromared
?>

<?php require '../actions/database.php'; 
    require 'actions/users/securityAction.php';
    require 'actions/securityActionAdmin.php';
    require 'actions/books/addBooksAction.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enregistrer un livre</title>
    <?php include '../includes/header.php'; ?>
</head>
<body>
<?php include 'includes/navbar.php'; ?>
<br />
<p>Les champs marqués d'une * sont obligatoires.</p>
<?php if(isset($msg)){echo '<br /><br />' . $msg;} ?>
<br />
<div class="update-part"><h4>Ajouter un livre</h4>
<form method="post" autocomplete="off">
<label for="title">Titre* : </label><input type="text" id="title" name="title"/><br />
<label for="author">Auteur* : </label><input type="text" id="author" name="author"/><ul class="list-author"></ul><?php include 'actions/books/list-author.php'; ?><br />
<label for="isbn">ISBN* : </label><input type="number" id="isbn" name="isbn"/><br />
<label for="id_u">Identifiant unique : </label><input type="text" id="id_u" name="id_unique"/><br />
<label for="resume">Résumé : </label><textarea id="resume" name="resume"></textarea><br />
<label for="editeur">Éditeur* : </label><input type="text" itemid="editeur" name="editeur" id="editeur"/><ul class="list-editeur"></ul><?php include 'actions/books/list-editeur.php'; ?><br />
<label for="genre">Genre : </label><input type="text" id="genre" name="genre"/><ul class="list-genre"></ul><?php include 'actions/books/list-genre.php'; ?><br />
<label for="type">Type* : </label><input type="text" id="type" name="type"/><ul class="list-type"></ul><?php include 'actions/books/list-type.php'; ?><br />
<label for="serie">Série : </label><input type="text" id="serie" name="serie"/><ul class="list-serie"></ul><?php include 'actions/books/list-serie.php'; ?><br />
<label for="tome">Tome : </label><input type="number" id="tome" name="tome" /><br />
<input type="submit" name="validate" value="Enregistrer"/>
</form>
</div>
</body>
</html>