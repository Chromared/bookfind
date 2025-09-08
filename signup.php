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
            <h5 class="card-title">Inscription</h5>
            <div class="row mb-3">
              <div class="col-md-6">
                <label for="firstname" class="form-label text-start d-block">Prénom</label>
                <input type="text" name="firstname" id="firstname" class="form-control" placeholder="John" required/>
              </div>
              <div class="col-md-6">
                <label for="lastname" class="form-label text-start d-block">Nom de famille</label>
                <input type="text" name="lastname" id="lastname" class="form-control" placeholder="Doe" required/>
              </div>
            </div>
            <div class="mb-3">
              <label for="classe" class="form-label text-start d-block">Classe</label>
              <select name="classe" id="classe" class="form-select" required>
                <option value>--- Sélectionner une classe ---</option>
                <?php include 'actions/functions/recupClassesAndOptions.php'; ?>
              </select>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label text-start d-block">Mot de passe</label>
              <input type="password" name="password" id="password" class="form-control" required/>
              <label for="confirm_password" class="form-label text-start d-block">Confirmer le mot de passe</label>
              <input type="password" name="confirm_password" id="confirm_password" class="form-control" required/>
            </div>
            <div class="mb-3">
              <input type="checkbox" name="rules-pdc" class="form-check-input" id="rules-pdc" required>
              <label class="form-check-label" for="rules-pdc">
                Je confirme avoir lu et accepté le <a href="rules.php" target="_blank">règlement</a> et la <a href="pdc.php" target="_blank">politique de confidentialité</a>
              </label>
            </div>
            <div class="mb-3">
              <input type="submit" name="validate" class="btn btn-primary" value="Inscription" />
            </div>
          </div>
        </div>
      </div>
    </div>
</form>
</body>
</html>