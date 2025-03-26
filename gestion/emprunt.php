<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2024 Chromared
?>

<?php require '../actions/database.php';
    require 'actions/users/securityAction.php';
    require 'actions/users/securityAdminAction.php';
    require '../actions/books/showOneBookAction.php';
    require 'actions/books/updateEmprunt.php';
    if($booksInfos['statut'] == 1){ require 'actions/books/showOneEmprunt.php'; }
    require 'actions/books/addEmpruntAction.php';
    require 'actions/books/returnEmprunt.php';

    $dateDans30Jours = date('Y-m-d', strtotime('+30 days')); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un emprunt</title>
    <?php include '../includes/header.php'; ?>
</head>
<body>
    <?php include 'includes/navbar.php'; ?>
    <br>
    <?php if(isset($msg)){$msg;}
        if($booksInfos['statut'] == 0 OR $booksInfos['statut'] == 2){ ?>
    <h4>Ajouter un emprunt</h4>
    <form method="post">
        <label>N° de carte de l'emprunteur : </label><input type="number" name="card" min="0" max="99999999" required/><br />
        <label>À rendre pour le : </label><input type="date" value="<?= $dateDans30Jours; ?>" name="date" required/><br />
        <input type="hidden" name="id_book" value="<?= htmlspecialchars($_GET['id']); ?>" />
        <input type="submit" name="validateAdd" value="Ajouter l'emprunt"/>
    </form>
        <?php }elseif($booksInfos['statut'] == 1){
            if(isset($_GET['card']) AND !empty($_GET['card'])){ ?>
    <div class="update-part">
        <h4>Modifier la date de retour de l'emprunt</h4>
        <form method="post">
        <input type="date" name="date" value="<?= $empruntInfos['date_futur_retour'] ?>" /><br />
        <input type="hidden" name="id" value="<?= $_GET['id'] ?>" />
            <input type="hidden" name="card" value="<?= $_GET['card'] ?>" />
        <input type="submit" name="validateUpdate" value="Enregistrer" />
        </form>
    </div>
    <hr />
    <div class="update-part">
        <form method="post">
            <input type="hidden" name="id" value="<?= $_GET['id'] ?>" />
            <input type="hidden" name="card" value="<?= $_GET['card'] ?>" />
            <input type="submit" name="validateReturn" value="Retourner l'emprunt" />
        </form>
    </div>
<?php }else{echo 'N° de carte de l\'utilisateur manquant.';}} ?>
</body>
</html>