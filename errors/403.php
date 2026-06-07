<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2025 Chromared
?>

<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr" data-bs-theme="<?php include '../actions/users/decodeThemeAction.php'; ?>">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Erreur 403</title>
  <?php include '../includes/header.php'; ?>
</head>

<body class="d-flex flex-column min-vh-100">
  <div class="container text-center mt-5">
    <h1 class="mt-3">Erreur 403</h1>
    <img src="../assets/iconesite.png" class="img-fluid w-25 display-4" />
    <h3 class="mt-3">Vous n'avez pas les autorisations nécessaires pour accéder à cette page.</h3>
    <?php if(!isset($_SESSION['auth'])) { ?>
      <a href="/login.php" class="btn btn-primary mt-3">Se connecter</a>
    <?php } ?>
  </div>
  <div class="container mt-3">
    <form method="GET" action="books.php">
      <div class="input-group mb-3">
        <input type="text" name="s" class="form-control" placeholder="Rechercher un livre" />
        <button class="btn btn-outline-secondary" type="submit" id="button-addon2">
          <i class="bi bi-search"></i>
          Rechercher
        </button>
      </div>
    </form>
  </div>
  <?php include '../includes/footer.php'; ?>
</body>

</html>