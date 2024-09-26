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
            <p>Résumé : <?php if(!empty($books['resume'])){ echo $books['resume']; }else{ echo 'Il n\'y a pas de résumé pour ce livre.'; } ?></p>
            <p><a style="color: black;" href="books-reader.php?id=<?= htmlspecialchars($books['id']); ?>">Voir le livre</a></p>
            <form method="get" action="<?php if(!isset($gestion)){ ?>gestion/<?php } ?>add-emprunt.php"><input type="hidden" name="id" value="<?= htmlspecialchars($books['id']); ?>"/><input type="submit" value="Ajouter un emprunt"/></form>
        </div>
        <br />
            

<?php }}else{ echo htmlspecialchars('Vous n\'avez pas d\'emprunts en cours.'); }} ?>
</div>
</body>
</html>