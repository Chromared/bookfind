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
<form method="POST">
    <div class="container mt-3">
      <div class="d-flex justify-content-center mt-4">
        <div class="card text-center mb-3" style="width: 50rem;">
          <div class="card-body">
            <?php if(isset($errorMsg)){ ?>
              <div class="alert alert-warning d-flex align-items-center justify-content-center" role="alert">
                <i class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2"></i>
                <div>
                  <?= $errorMsg; ?>
                </div>
              </div>
            <?php } ?>
            <div class="input-group mb-3">
              <input type="text" name="firstname" class="form-control" placeholder="Prénom" required/>
              <input type="text" name="name" class="form-control" placeholder="Nom de famille" required/>
            </div>
            <div class="mb-3">
              <input type="number" name="card" class="form-control" placeholder="Numéro de carte" value="<?php if(isset($_GET['card'])){echo $_GET['card'];}?>" required/>
            </div>
            <div class="mb-3">
              <select name="classe" class="form-select" required>
                <option value>--- Sélectionner une classe ---</option>
                <?php include 'actions/functions/recupClassesAndOptions.php'; ?>
              </select>
            </div>
            <div class="input-group mb-3">
              <input type="password" name="password" class="form-control" placeholder="Mot de passe" required/>
              <input type="password" name="confirm_password" class="form-control" placeholder="Confirmer le mot de passe" required/>
            </div>
            <div class="mb-3">
              <input type="checkbox" name="rules-pdc" class="form-check-input" id="rules-pdc" autocomplete="off" required>
              <label class="form-check-label" for="rules-pdc">
                Je confirme avoir lu et accepté le <a href="rules.php">règlement</a> et la <a href="pdc.php">politique de confidentialité</a>
              </label>
            </div>
            <div class="mb-3">
              <input type="submit" name="validate" class="btn btn-primary" value="Inscription" />
              <?php if(isset($_GET['card']) AND !empty($_GET['card'])){ ?><input type="reset" class="btn btn-secondary" value="Réinitialiser le formulaire" /><?php } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
</form>
</body>
</html>