<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2024 Chromared
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
    <div class="search-part">
        <h1>Bienvenue sur BookFind ! Ici, empruntez les livres du C.D.I !</h1><br>
        <form method="GET" action="books.php">
                <input type="search" name="s" action="books.php" class="searchbar" placeholder="Rechercher ici les livres du CDI" />
                <button type="submit" class="searchbutton" ><i class="fa-solid fa-magnifying-glass" style="color: snow;"></i></button>
        </form>
    </div>
</body>
</html>