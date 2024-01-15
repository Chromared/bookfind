<?php session_start() ?>
<?php require 'actions/database.php';?>
<?php require 'actions/users/loginAction.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'includes/header.php'; ?>
</head>
<body>
<?php include 'includes/navbar.php'; ?>
<p>
<?php if(isset($errorMsg)){ echo '<p>'.$errorMsg.'</p>'; } ?>
<form method="POST" class="form">
    <fieldset class="form-fieldset"><legend class="form-legend">Se connecter</legend>
    <label class="form-label">Numéro de carte : </label><input type="number" max="99999999" required="required" name="card" class="form-control" />
    <br /><label class="form-label">Mot de passe : </label><input type="password" required="required" name="password" class="form-control" />
    <br /><input class="form-btn-submit" type="submit" name="validate" value="Connexion !" /> <input type="reset" value="Réinitialiser le formulaire" class="form-btn-reset" />
    </fieldset>
</form>
</p>
</body>
</html>