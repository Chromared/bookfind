<?php session_start(); 
    require 'actions/database.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'includes/header.php'; ?>
</head>
<body>
    <?php include 'includes/navbar.php'; ?>
    <br><div class="booksearch-part">   
        <form method="GET">
            <input type="search" name="s" placeholder="Rechercher ici les livres du CDI"/>
            <button type="submit"><i class="fa-solid fa-magnifying-glass fa-beat"></i></button>
        </form>
        <br />
        <?php include 'actions/books/sBooks.php'; ?>
    </div>
</body>
</html>