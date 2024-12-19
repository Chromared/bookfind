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
<p>Vous pouvez utiliser <em>CTRL + ENTER</em> ou <em>CMD + ENTER</em> pour valider.</p>
<?php if(isset($msg)){ echo '<p>' . $msg . '</p>'; } ?>
<br />
<div class="update-part"><h4>Ajouter un livre</h4>
<form method="post" autocomplete="off">
<input placeholder="Titre*" type="text" id="title" name="title" required/><br />
<input placeholder="Auteur*" type="text" id="author" name="author" required/><span class="list-author"></span><?php include 'actions/books/list-author.php'; ?><br />
<input placeholder="ISBN*" type="number" id="isbn" name="isbn" required/><br />
<input placeholder="Type*" type="text" id="type" name="type" required/><span class="list-type"></span><?php include 'actions/books/list-type.php'; ?><br />
<input placeholder="Éditeur*" type="text" itemid="editeur" name="editeur" id="editeur" required/><span class="list-editeur"></span><?php include 'actions/books/list-editeur.php'; ?><br />
<textarea placeholder="Résumé" id="resume" name="resume"></textarea><br />
<input placeholder="Identifiant unique" type="text" id="id_u" name="id_unique"/><br />
<input placeholder="Genre" type="text" id="genre" name="genre" /><span class="list-genre"></span><?php include 'actions/books/list-genre.php'; ?><br />
<input placeholder="Série" type="text" id="serie" name="serie" /><span class="list-serie"></span><?php include 'actions/books/list-serie.php'; ?><br />
<input placeholder="Tome (n°)" type="number" id="tome" name="tome" /><br />
<input type="hidden" name="validate" />
<input type="submit" name="validate" title="Ctrl + Enter / Cmd + Enter" value="Enregistrer"/>

<script>
    document.querySelector('form').addEventListener('keydown', function(e) {
    if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
    e.preventDefault();
    this.submit();
    }});
</script>

</form>
</div>
</body>
</html>