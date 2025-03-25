<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2024 Chromared
?>

<?php require '../actions/database.php';
    require '../actions/users/securityAction.php';
    require 'actions/users/securityAdminAction.php';
    require '../actions/books/showEmprunts.php';
    require '../actions/functions/conversionDateHour.php';
    require '../actions/functions/conversionDate.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emprunts</title>
    <?php include '../includes/header.php' ?>
</head>
<body>
    <?php include 'includes/navbar.php'?>
    <?php if (isset($_GET['card'])) {

        echo '<h3>Emprunts en cours : </h3>';

        if($selectInfosFromEmprunts1->rowCount() > 0){
            
            while($empruntsInfos1 = $selectInfosFromEmprunts1->fetch()){
                
            $selectInfosFromBooksEmprunts1= $bdd->prepare('SELECT * FROM books WHERE id = ?');
            $selectInfosFromBooksEmprunts1->execute(array($empruntsInfos1['id_book']));
            $recupBooks = $selectInfosFromBooksEmprunts1->fetch(); ?>

        <div class="bordure">
            <h4><?= htmlspecialchars($recupBooks['titre']); ?></h4>
            <p>Auteur : <?= htmlspecialchars($recupBooks['auteur']); ?></p>
            <p>Date de l'emprunt : <?= ConversionDateHour($empruntsInfos1['date_emprunt']); ?></p>
            <p>Date de retour prévue : <?= ConversionDate($empruntsInfos1['date_futur_retour']); ?></p>
            <p><a style="color: black;" href="books-reader.php?id=<?= htmlspecialchars($recupBooks['id']); ?>">Voir le livre</a></p>
        </div>
        <br />

<?php }}else{ echo '<p>Cet utilisateur n\'a pas d\'emprunts en cours.</p>'; }

    echo '<h3>Emprunts retournés : </h3>';

if($selectInfosFromEmprunts2->rowCount() > 0){
            
    while($empruntsInfos2= $selectInfosFromEmprunts2->fetch()){

            $selectInfosFromBooksEmprunts2= $bdd->prepare('SELECT * FROM books WHERE id = ?');
            $selectInfosFromBooksEmprunts2->execute(array($empruntsInfos2['id_book']));
            $recupBooks = $selectInfosFromBooksEmprunts2->fetch(); ?>

        <div class="bordure">
            <h4><?= htmlspecialchars($recupBooks['titre']); ?></h4>
            <p>Auteur : <?= htmlspecialchars($recupBooks['auteur']); ?></p>
            <p>Date de l'emprunt : <?= ConversionDateHour($empruntsInfos2['date_emprunt']); ?></p>
            <p>Date de retour : <?= ConversionDateHour($empruntsInfos2['date_retour']); ?></p>
            <p><a style="color: black;" href="books-reader.php?id=<?= htmlspecialchars($recupBooks['id']); ?>">Voir le livre</a></p>
        </div>
        <br />

<?php }}else{ echo '<p>Cet utilisateur n\'a pas d\'emprunts qui ont été retournés.</p>'; }} ?>
</div>
</body>
</html>