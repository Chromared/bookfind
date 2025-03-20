<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2024 Chromared
?>

<?php session_start(); 
    require 'actions/database.php';
    require 'actions/functions/conversionDate.php';
    require 'actions/functions/conversionDateHour.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rechercher un livre</title>
    <?php include 'includes/header.php'; ?>
</head>
<body>
    <?php include 'includes/navbar.php'; ?>
    <br><div class="booksearch-part">   
        <form method="GET">
            <input type="search" name="s" value="<?php if(isset($_GET['s']) AND !empty($_GET['s'])){echo htmlspecialchars($_GET['s']);} ?>" placeholder="Rechercher ici les livres du CDI"/>
            <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
        </form>
        <br />
        <?php include 'actions/books/sBooks.php'; ?>
    </div>
</body>
</html>