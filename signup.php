<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2024 Chromared
?>

<?php session_start(); ?>
<?php require 'actions/database.php';
    require 'actions/functions/logFunction.php';
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
<?php if(isset($errorMsg)){ echo '<p>' . $errorMsg . '</p>'; } ?>
<form method="POST" class="form">
    <div class="form-signup">
        <br><label class="form-label" for="name">Nom</label>
        <br><input type="text" maxlength="50" id="name" name="name" class="form-control" required/>

        <br /><label class="form-label" for="firstname">Prénom</label>
        <br><input type="text" maxlength="25" id="firstname" name="firstname" class="form-control" required/>

        <br /><label class="form-label" for="card">Numéro de carte</label>
        <br><input value="<?php if(isset($_GET['card'])){echo $_GET['card'];}?>" type="number" id="card" name="card" class="form-control" required/>

        <br /><label class="form-label" for="classe">Classe</label>
        <br><select class="form-control" name="classe" id="classe" required><option value>--- Sélectionner une classe ---</option><?php include 'actions/functions/recupClassesAndOptions.php'; ?></select>

        <br /><label class="form-label" for="password">Mot de passe</label>
        <br><input type="password" id="password" name="password" class="form-control" required/>

        <br /><label class="form-label" for="confirm_password">Confirmer le mot de passe</label>
        <br><input type="password" id="confirm_password" name="confirm_password" class="form-control" required/>

        <br /><input class="form-checkbox" type="checkbox" id="rules-pdc" name="rules-pdc" required/> <label for="rules-pdc" class="form-label">Je confirme avoir lu et accepté le <a href="rules.php" target="_blank">règlement</a> et la <a href="pdc.php" target="_blank">politique de confidentialité</a></label>

        <br /><input class="form-btn-blue" type="submit" name="validate" value="Inscription" /> <input type="reset" value="Réinitialiser le formulaire" class="form-btn-blue" />
    </div>
</form>
</p>
</body>
</html>