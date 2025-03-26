<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2024 Chromared
?>

<?php session_start();
    require 'actions/database.php';
    require 'actions/books/showOneBookAction.php';
    require 'actions/books/showOneEmprunt.php';
    require 'actions/functions/conversionDate.php';
    require 'actions/functions/conversionDateHour.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informations sur le livre</title>
    <?php include 'includes/header.php'; ?>
</head>
<body>
    <?php include 'includes/navbar.php'; ?>
<div class="contour">
<div class="reader-part">
<div class="book-name"><h4><?= htmlspecialchars($booksInfos['titre']); ?></h4></div>
<div class="books-infos">
    <p>
        ID : <?= htmlspecialchars($booksInfos['id']); ?><br />
        Auteur : <?= htmlspecialchars($booksInfos['auteur']); ?><br />
        Résumé : <?php if(!empty($booksInfos['resume'])){ echo $booksInfos['resume']; }else{ echo 'Il n\'y a pas de résumé pour ce livre.'; } ?><br />
        Identifiant unique : <?php if(!empty($booksInfos['id_unique'])){ echo $booksInfos['id_unique']; }else{ echo 'Il n\'y a pas d\'identifiant unique pour ce livre.'; } ?><br />
        ISBN : <?= htmlspecialchars($booksInfos['isbn']); ?><br />
        Éditeur : <?= htmlspecialchars($booksInfos['editeur']); ?><br />
        Type : <?= htmlspecialchars($booksInfos['type']); ?><br />
        Genre : <?php if(!empty($booksInfos['genre'])){ echo $booksInfos['genre']; }else{ echo 'Il n\'y a pas de genre pour ce livre.'; } ?><br />
        <?php if(!empty($booksInfos['serie'])){ echo 'Tome ' . $booksInfos['tome'] . ' de la série ' . $booksInfos['serie'] . '.'; } ?><br />
        
        <?php if(isset($_SESSION['auth'])){ if($_SESSION['grade'] != 0){
                         if($booksInfos['statut'] == 0 OR $booksInfos['statut'] == 2){?>

                            <form method="get" action="<?php if(!isset($gestion)){ ?>gestion/<?php } ?>emprunt.php">
                                <input type="hidden" name="id" value="<?= htmlspecialchars($booksInfos['id']); ?>"/>
                                <input type="submit" value="Emprunter ce livre"/>
                            </form>
                    
                        <?php }elseif($booksInfos['statut'] == 1){?>

                            <p>Emprunté par : <?= htmlspecialchars($emprunt['firstname_name']); ?></p>
                            <p>Le : <?php ConversionDateHour($emprunt['date_emprunt']); ?></p>
                            <p>Retour prévu le : <?php ConversionDate($emprunt['date_futur_retour']); ?></p>
                            <form method="get" action="<?php if(!isset($gestion)){ ?>gestion/<?php } ?>emprunt.php">
                                <input type="hidden" name="id" value="<?= htmlspecialchars($booksInfos['id']); ?>"/>
                                <input type="hidden" name="card" value="<?= htmlspecialchars($emprunt['card_emprunteur']); ?>"/>
                                <input type="submit" value="Modifier l'emprunt de ce livre"/>
                            </form>
                <?php }}} ?>

    </p>
</div></div>
</div>
</body>
</html>