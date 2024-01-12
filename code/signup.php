<?php require 'actions/database.php';?>
<?php require 'actions/users/signupAction.php'; ?>
<?php session_start() ?>
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

    <label class="form-label">Nom : </label><input type="text" maxlength="20" name="name" required="required" class="form-control"/>
    <br /><label class="form-label">Prénom : </label><input type="text" maxlength="15" name="firstname" required="required" class="form-control"/>
    <br /><label class="form-label">Mot de passe : </label><input type="password" name="password"  required="required" class="form-control"/>
    <br /><label class="form-label">Confirmer le mot de passe : </label><input type="password" name="confirm_password" required="required" class="form-control"/>
    <br /><label class="form-label">Numéro de carte : </label><input type="number" maxlength="8" max="99999999" required="required" name="card" class="form-control"/>
    <br /><label class="form-label">Classe : </label><select value="<?php if(isset($_GET['card'])){echo $_GET['card'];}?>" class="form-control" name="classe" required="required" ><option value="6B">6B</option><option value="5B">5B</option><option value="4B">4B</option><option value="3B">3B</option><option value="6R">6R</option><option value="5R">5R</option><option value="4R">4R</option><option value="3R">3R</option><option value="6J">6J</option><option value="5J">5J</option><option value="4J">4J</option><option value="3J">3J</option><option value="6V">6V</option><option value="5V">5V</option><option value="4V">4V</option><option value="3V">3V</option></select>
    <br /><label class="form-label">Je confirme avoir lu et accepté-e le <a href="rules.php" target="_blank">réglement</a> et les <a href="cu.php" target="_blank">conditions d'utilisations</a> : </label><input required="required" type="checkbox" name="rules-cu"/>
    <br /><input class="form-btn-submit" type="submit" name="validate" value="Inscription !" /> <input type="reset" value="Réinitialiser le formulaire" class="form-btn-reset" />

</form>
</p>
</body>
</html>