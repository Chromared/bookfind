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
<form method="POST">
    <div class="container mt-3">
      <div class="d-flex justify-content-center mt-4">
        <div class="card text-center mb-3" style="width: 50rem;">
          <div class="card-body">
            <?php if(isset($errorMsg)){ ?>
              <div class="alert alert-warning d-flex align-items-center" role="alert">
                <i class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2"></i>
                <div>
                  <?= $errorMsg; ?>
                </div>
              </div>
            <?php } ?>
            <div class="mb-3">
              <input type="text" name="card" class="form-control" placeholder="Numéro de carte" autofocus required/>
            </div>
            <div class="mb-3">
              <input type="password" name="password" class="form-control" placeholder="Mot de passe" required/>
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