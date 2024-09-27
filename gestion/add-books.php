<?php require '../actions/database.php'; 
      require '../actions/users/securityAction.php';
      require 'actions/securityActionAdmin.php';
      require 'actions/books/addBooksAction.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include '../includes/header.php'; ?>
</head>
<body>
<?php include 'includes/navbar.php'; ?>
<p><br />
Les champs marqués d'une * sont obligatoires.
<?php if(isset($msg)){echo '<br /><br />' . $msg;} ?>
<br />
<fieldset><legend>Ajouter un livre</legend>
<form method="post" autocomplete="off">
<label>Titre* : </label><input type="text" name="title"/><br />
<label>Auteur* : </label><input type="text" id="author" name="author"/><ul class="list-author"></ul><?php include 'actions/books/list-author.php'; ?><br />
<label>ISBN* : </label><input type="number" name="isbn"/><br />
<label>Identifiant unique : </label><input type="text" name="id_unique"/><br />
<label>Résumé : </label><textarea name="resume"></textarea><br />
<label>Éditeur* : </label><input type="text" name="editeur" id="editeur"/><ul class="list-editeur"></ul><?php include 'actions/books/list-editeur.php'; ?><br />
<label>Genre : </label><input type="text" id="genre" name="genre"/><ul class="list-genre"></ul><?php include 'actions/books/list-genre.php'; ?><br />
<label>Type* : </label><input type="text" id="type" name="type"/><ul class="list-type"></ul><?php include 'actions/books/list-type.php'; ?><br />
<label>Série : </label><input type="text" id="serie" name="serie"/><ul class="list-serie"></ul><?php include 'actions/books/list-serie.php'; ?><br />
<label>Tome : </label><input type="number" name="tome" /><br />
<input type="submit" name="validate" value="Enregistrer"/>
</form>
</fieldset>
</p>
</body>
</html>