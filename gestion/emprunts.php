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
    require 'actions/books/showAllEmprunts.php';
    require '../actions/functions/conversionDateHour.php';
    require '../actions/functions/conversionDate.php';
    require '../actions/functions/colorDateEmpruntFunction.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emprunts</title>
    <?php include '../includes/header.php'; ?>
</head>
<body>
    <?php include 'includes/navbar.php'; ?>
    <p><a href="#en_retard">En retard</a> <a href="#aujourdhui">Aujourd'hui</a> <a href="#en_cours">En cours</a> <a href="#retournes">Retournés</a></p>
    <?php echo '<h3 id="en_retard">Emprunts en retard : </h3>';

        if($selectInfosFromEmprunts1->rowCount() > 0){
            
            while($empruntsInfos1 = $selectInfosFromEmprunts1->fetch()){
                
            $selectInfosFromBooksEmprunts1= $bdd->prepare('SELECT * FROM books WHERE id = ?');
            $selectInfosFromBooksEmprunts1->execute(array($empruntsInfos1['id_book']));
            $recupBooks = $selectInfosFromBooksEmprunts1->fetch(); ?>

        <div class="bordure">
            <h4><?= htmlspecialchars($recupBooks['titre']); ?></h4>
            <p>Auteur : <?= htmlspecialchars($recupBooks['auteur']); ?></p>
            <p>Date de l'emprunt : <?= ConversionDateHour($empruntsInfos1['date_emprunt']); ?></p>
            <p>Date de retour prévue : <?= ColorDateEmprunt($empruntsInfos1['date_futur_retour']); ?></p>
            <p><a style="color: black;" href="books-reader.php?id=<?= htmlspecialchars($recupBooks['id']); ?>">Voir le livre</a></p>
        </div>
        <br />

<?php }}else{ echo '<p>Il n\'y a pas d\'emprunts en retard.</p>'; }

    echo '<h3 id="aujourdhui">Emprunts qui doivent être rendus aujourd\'hui : </h3>';

        if($selectInfosFromEmprunts2->rowCount() > 0){
            
            while($empruntsInfos2 = $selectInfosFromEmprunts2->fetch()){
                
            $selectInfosFromBooksEmprunts2= $bdd->prepare('SELECT * FROM books WHERE id = ?');
            $selectInfosFromBooksEmprunts2->execute(array($empruntsInfos2['id_book']));
            $recupBooks = $selectInfosFromBooksEmprunts2->fetch(); ?>

        <div class="bordure">
            <h4><?= htmlspecialchars($recupBooks['titre']); ?></h4>
            <p>Auteur : <?= htmlspecialchars($recupBooks['auteur']); ?></p>
            <p>Date de l'emprunt : <?= ConversionDateHour($empruntsInfos2['date_emprunt']); ?></p>
            <p>Date de retour prévue : <?= ColorDateEmprunt($empruntsInfos2['date_futur_retour']); ?></p>
            <p><a style="color: black;" href="books-reader.php?id=<?= htmlspecialchars($recupBooks['id']); ?>">Voir le livre</a></p>
        </div>
        <br />

<?php }}else{ echo '<p>Il n\'y a pas d\'emprunts qui doivent être rendus aujourd\'hui.</p>'; }

    echo '<h3 id="en_cours">Emprunts en cours : </h3>';
        
        if($selectInfosFromEmprunts3->rowCount() > 0){
            
            while($empruntsInfos3 = $selectInfosFromEmprunts3->fetch()){
                
            $selectInfosFromBooksEmprunts3= $bdd->prepare('SELECT * FROM books WHERE id = ?');
            $selectInfosFromBooksEmprunts3->execute(array($empruntsInfos3['id_book']));
            $recupBooks = $selectInfosFromBooksEmprunts3->fetch(); ?>
        
        <div class="bordure">
            <h4><?= htmlspecialchars($recupBooks['titre']); ?></h4>
            <p>Auteur : <?= htmlspecialchars($recupBooks['auteur']); ?></p>
            <p>Date de l'emprunt : <?= ConversionDateHour($empruntsInfos3['date_emprunt']); ?></p>
            <p>Date de retour prévue : <?= ColorDateEmprunt($empruntsInfos3['date_futur_retour']); ?></p>
            <p><a style="color: black;" href="books-reader.php?id=<?= htmlspecialchars($recupBooks['id']); ?>">Voir le livre</a></p>
        </div>
        <br />

<?php }}else{ echo '<p>Il n\'y a pas d\'emprunts en cours.</p>'; }

    echo '<h3 id="retournes">Emprunts retournés : </h3>';

if($selectInfosFromEmprunts4->rowCount() > 0){
            
    while($empruntsInfos4 = $selectInfosFromEmprunts4->fetch()){

            $selectInfosFromBooksEmprunts4 = $bdd->prepare('SELECT * FROM books WHERE id = ?');
            $selectInfosFromBooksEmprunts4->execute(array($empruntsInfos4['id_book']));
            $recupBooks = $selectInfosFromBooksEmprunts4->fetch(); ?>

        <div class="bordure">
            <h4><?= htmlspecialchars($recupBooks['titre']); ?></h4>
            <p>Auteur : <?= htmlspecialchars($recupBooks['auteur']); ?></p>
            <p>Date de l'emprunt : <?= ConversionDateHour($empruntsInfos4['date_emprunt']); ?></p>
            <p>Date de retour : <?= ConversionDateHour($empruntsInfos4['date_retour']); ?></p>
            <p><a style="color: black;" href="books-reader.php?id=<?= htmlspecialchars($recupBooks['id']); ?>">Voir le livre</a></p>
        </div>
        <br />

<?php }}else{ echo 'Il n\'y pas d\'emprunts qui ont été retournés.'; } ?>
</div>
</body>
</html>