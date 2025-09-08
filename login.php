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
              <div class="alert alert-warning d-flex align-items-center justify-content-center" role="alert">
                <i class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2"></i>
                <div>
                  <?= $errorMsg; ?>
                </div>
              </div>
            <?php } ?>
            <h5 class="card-title">Connexion</h5>
            <div class="mb-3">
              <label for="username" class="form-label text-start d-block">Nom d'utilisateur</label>
              <input type="text" name="username" id="username" class="form-control" placeholder="jdoe" autofocus required/>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label text-start d-block">Mot de passe</label>
              <input type="password" name="password" id="password" class="form-control" required/>
            </div>
            <div class="mb-3">
              <input type="submit" name="validate" class="btn btn-primary" value="Connexion" />
            </div>
          </div>
        </div>
      </div>
    </div>
</form>
</body>
</html>