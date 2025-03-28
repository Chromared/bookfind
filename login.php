<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2025 Chromared
?>

<?php session_start(); ?>
<?php require 'actions/database.php';
    require 'actions/functions/logFunction.php';
    require 'actions/users/loginAction.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <?php include 'includes/header.php'; ?>
</head>
<body>
<?php include 'includes/navbar.php'; ?>
<p>
<?php if(isset($errorMsg)){ echo '<p>'.$errorMsg.'</p>'; } ?>
<form method="POST" class="form">
        <div class="form-login">
            <br><label class="form-label" for="card">Numéro de carte : </label><input type="text" name="card" id="card" class="form-control" autofocus required/>

            <br /><label class="form-label" for="password">Mot de passe : </label><input type="password" name="password" id="password" class="form-control" required/>

            <br /><input class="form-btn-blue" type="submit" name="validate" value="Connexion" />
        </div>
</form>
</p>
</body>
</html>