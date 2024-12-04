<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2024 Chromared
?>

<?php require '../actions/database.php';
    require '../actions/users/securityAction.php';
    require 'actions/securityActionAdmin.php';
    require 'actions/books/showOneEmprunt.php'; ?>
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
    <div class="update-part">
        <h4>Modifier la date de retour de l'emprunt</h4>
        <form method="get">
        <input type="date" name="date" value="<?= $empruntInfos['date_retour'] ?>" /><br />
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
</body>
</html>