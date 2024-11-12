<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2024 Chromared
?>

<?php $page = 'signup.php'; ?>

<?php session_start(); ?>
<?php require 'actions/database.php';
    require 'actions/fonctions/logFunction.php';
    require 'actions/users/signupAction.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <?php include 'includes/header.php'; ?>
</head>
<body>
<?php include 'includes/navbar.php'; ?>
<p>
<?php if(isset($errorMsg)){ echo '<p>'.$errorMsg.'</p>'; } ?>
<form method="POST" class="form">
    <div class="form-signup">
        <br><label class="form-label">Nom</label>
        <br><input type="text" maxlength="50" name="name" class="form-control"/>

        <br /><label class="form-label">Prénom</label>
        <br><input type="text" maxlength="25" name="firstname" class="form-control"/>

        <br /><label class="form-label">Numéro de carte</label>
        <br><input value="<?php if(isset($_GET['card'])){echo $_GET['card'];}?>" type="number" name="card" class="form-control"/>

        <br /><label class="form-label">Classe</label>
        <br><select class="form-control" name="classe"><option value="6B">6B</option><option value="5B">5B</option><option value="4B">4B</option><option value="3B">3B</option><option value="6R">6R</option><option value="5R">5R</option><option value="4R">4R</option><option value="3R">3R</option><option value="6J">6J</option><option value="5J">5J</option><option value="4J">4J</option><option value="3J">3J</option><option value="6V">6V</option><option value="5V">5V</option><option value="4V">4V</option><option value="3V">3V</option></select>

        <br /><label class="form-label">Mot de passe</label>
        <br><input type="password" name="password" class="form-control"/>

        <br /><label class="form-label">Confirmer le mot de passe</label>
        <br><input type="password" name="confirm_password" class="form-control"/>

        <br /><input class="form-checkbox" type="checkbox" id="rules-pdc" name="rules-pdc"/> <label for="rules-pdc" class="form-label">Je confirme avoir lu et accepté le <a href="rules.php" target="_blank">règlement</a> et la <a href="pdc.php" target="_blank">politique de confidentialité</a></label>

        <br /><input class="form-btn-blue" type="submit" name="validate" value="Inscription" /> <input type="reset" value="Réinitialiser le formulaire" class="form-btn-blue" />
    </div>
</form>
</p>
</body>
</html>