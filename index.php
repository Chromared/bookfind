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
        <h1>Bienvenue sur BookFind ! Ici, empruntez les livres du C.D.I !</h1><br />
        <div class="container mt-3">
            <form method="GET" action="books.php">
                <div class="input-group mb-3">
                  <input type="text" name="s" class="form-control" value="<?php if(isset($_GET['s']) AND !empty($_GET['s'])){echo htmlspecialchars($_GET['s']);} ?>" placeholder="Rechercher un livre" <?php if(!isset($_GET['s']) OR empty($_GET['s'])){ echo 'autofocus'; } ?> />
                  <button class="btn btn-outline-secondary" type="submit" id="button-addon2">
                    <i class="bi bi-search"></i>
                    Rechercher
                  </button>
                </div>
            </form>
        </div>
</body>
</html>