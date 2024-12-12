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
<?php if(isset($msg)){echo '<p>' . $msg . '</p>';}
    if(isset($_GET['msg']) AND !empty($_GET['msg']) AND $_GET['msg'] == true){echo '<p>Le livre a bien été enregistré.</p>';}?>
<br />
<div class="update-part"><h4>Ajouter un livre</h4>
<form method="post" autocomplete="off">
<label for="title">Titre* : </label><input type="text" id="title" name="title" required/><br />
<label for="author">Auteur* : </label><input type="text" id="author" name="author" required/><span class="list-author"></span><?php include 'actions/books/list-author.php'; ?><br />
<label for="isbn">ISBN* : </label><input type="number" id="isbn" name="isbn" required/><br />
<label for="type">Type* : </label><input type="text" id="type" name="type" required/><span class="list-type"></span><?php include 'actions/books/list-type.php'; ?><br />
<label for="editeur">Éditeur* : </label><input type="text" itemid="editeur" name="editeur" id="editeur" required/><span class="list-editeur"></span><?php include 'actions/books/list-editeur.php'; ?><br />
<label for="resume">Résumé : </label><textarea id="resume" name="resume"></textarea><br />
<label for="id_u">Identifiant unique : </label><input type="text" id="id_u" name="id_unique"/><br />
<label for="genre">Genre : </label><input type="text" id="genre" name="genre" /><span class="list-genre"></span><?php include 'actions/books/list-genre.php'; ?><br />
<label for="serie">Série : </label><input type="text" id="serie" name="serie" /><span class="list-serie"></span><?php include 'actions/books/list-serie.php'; ?><br />
<label for="tome">Tome : </label><input type="number" id="tome" name="tome" /><br />
<input type="hidden" name="validate" />
<input type="submit" name="validate" title="Ctrl + Enter / Cmd + Enter" value="Enregistrer"/>

<script>
    document.querySelector('form').addEventListener('keydown', function(e) {
    if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
    e.preventDefault();
    this.submit(); // Soumet le formulaire si Ctrl + Entrée est pressé
    }});
</script>

</form>
</div>
</body>
</html>