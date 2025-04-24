<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2025 Chromared
?>

<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <?php include 'includes/header.php'; ?>
</head>
<body>
    <?php include 'includes/navbar.php'; ?>
    <div class="container text-center mt-5">
      <img src="style/iconesite.png" class="display-4" />
      <h1 class="mt-3">Bienvenue sur BookFind !</h1>
    </div>
    <div class="container mt-3">
        <form method="GET" action="books.php">
            <div class="input-group mb-3">
              <input type="text" name="s" class="form-control" value="<?php if(isset($_GET['s']) AND !empty($_GET['s'])){echo htmlspecialchars($_GET['s']);} ?>" placeholder="Rechercher un livre" />
              <button class="btn btn-outline-secondary" type="submit" id="button-addon2">
                <i class="bi bi-search"></i>
                Rechercher
              </button>
            </div>
        </form>
    </div>
</body>
</html>