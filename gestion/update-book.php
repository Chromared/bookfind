<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2025 Chromared
?>

<?php require '../actions/database.php'; 
    require 'actions/users/securityAction.php';
    require 'actions/users/securityAdminAction.php';
    require 'actions/books/updateBooksAction.php';
    require '../actions/books/showOneBookAction.php'; ?>
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
<?php if(isset($msg)){ echo '<p>' . $msg . '</p>'; } ?>
<br />

<div class="update-part"><h4>Modifier le livre</h4>
<form method="post" autocomplete="off">

<input placeholder="ISBN*" type="number" value="<?= htmlspecialchars($booksInfos['isbn']); ?>" id="isbn" name="isbn" min="0000000001" max="9999999999999" autofocus required/><br />
<input placeholder="Titre*" type="text" value="<?= htmlspecialchars($booksInfos['titre']); ?>" id="title" name="title" required/><br />
<input placeholder="Auteur*" type="text" value="<?= htmlspecialchars($booksInfos['auteur']); ?>" id="author" name="author" required/><br />
<input placeholder="Type*" type="text" value="<?= htmlspecialchars($booksInfos['type']); ?>" id="type" name="type" required/><br />
<input placeholder="Éditeur*" type="text" value="<?= htmlspecialchars($booksInfos['editeur']); ?>" itemid="editeur" name="editeur" id="editeur" required/><br />
<textarea placeholder="Résumé" value="<?= htmlspecialchars($booksInfos['resume']); ?>" id="resume" name="resume"></textarea><br />
<input placeholder="Identifiant unique" type="text" value="<?= htmlspecialchars($booksInfos['id_unique']); ?>" id="id_u" name="id_unique"/><br />
<input placeholder="Genre" type="text" value="<?= htmlspecialchars($booksInfos['genre']); ?>" id="genre" name="genre"/><br />
<input placeholder="Série" type="text" value="<?= htmlspecialchars($booksInfos['serie']); ?>" id="serie" name="serie"/><br />
<input placeholder="Tome (n°)" type="number" value="<?php if(!empty($booksInfos['serie'])){ echo htmlspecialchars($booksInfos['tome']); } ?>" id="tome" name="tome" min="0"/><br />
<input type="submit" name="validate" value="Enregistrer"/>

</form>
</div>
</body>
</html>