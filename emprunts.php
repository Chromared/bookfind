<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2024 Chromared
?>

<?php require 'actions/database.php';
    //require 'actions/fonctions/logFunction.php';
    require 'actions/users/securityAction.php';
    require 'actions/books/showEmprunts.php';
    require 'actions/fonctions/conversionDateHour.php';
    require 'actions/fonctions/conversionDate.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emprunts</title>
    <?php include 'includes/header.php' ?>
</head>
<body>
    <?php include 'includes/navbar.php'?>
    <?php if (isset($_GET['card'])) {
        if($selectInfosFromEmprunts->rowCount() > 0){
            
            while($empruntsInfos = $selectInfosFromEmprunts->fetch()){
                
            $selectInfosFromBooksEmprunts= $bdd->prepare('SELECT * FROM books WHERE id = ?');
            $selectInfosFromBooksEmprunts->execute(array($empruntsInfos['id_book']));
            $recupBooks = $selectInfosFromBooksEmprunts->fetch(); ?>

        <div class="bordure">
            <h4><?= htmlspecialchars($recupBooks['titre']); ?></h4>
            <p>Auteur : <?= htmlspecialchars($recupBooks['auteur']); ?></p>
            <p>Date de l'emprunt : <?= ConversionDateHour($empruntsInfos['date_emprunt']); ?></p>
            <p>Date de retour prévue : <?= ConversionDate($empruntsInfos['date_retour']); ?></p>
            <p><a style="color: black;" href="books-reader.php?id=<?= htmlspecialchars($recupBooks['id']); ?>">Voir le livre</a></p>
        </div>
        <br />

<?php }}else{ echo htmlspecialchars('Vous n\'avez pas d\'emprunts en cours.'); }} ?>
</div>
</body>
</html>