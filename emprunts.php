<?php require 'actions/database.php'; 
      require 'actions/users/securityAction.php';
      require 'actions/books/showEmprunts.php';?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'includes/header.php' ?>
</head>
<body>
    <?php include 'includes/navbar.php'?>
    <?php if (isset($_GET['id'])) { ?>
    <?php

    if($empruntsInfos->rowCount() >= 1){ ?>
 <?php  while($books = $recupBooks->fetch()){ ?>
        <div class="bordure">
            <h4><?= htmlspecialchars($books['titre']); ?></h4>
            <p>Auteur : <?= htmlspecialchars($books['auteur']); ?></p>
            <p>Date de l'emprunt : </p>
            <p>Date de retour prévue : </p>
            <p><a style="color: black;" href="books-reader.php?id=<?= htmlspecialchars($books['id']); ?>">Voir le livre</a></p>
        </div>
        <br />

<?php }}else{ echo htmlspecialchars('Vous n\'avez pas d\'emprunts en cours.'); }} ?>
</div>
</body>
</html>