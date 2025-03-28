<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2025 Chromared
?>

<?php require '../actions/database.php'; 
    require 'actions/users/securityAction.php';
    require 'actions/users/securityAdminAction.php';?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rechercher des utilisateurs</title>
    <?php include '../includes/header.php'; ?>
</head>
<body>
    <?php include 'includes/navbar.php'; ?>
        <div class="usersgestion-part">
    <form method="GET" class="form">
        <br /><input type="search" name="s" value="<?php if(isset($_GET['s']) AND !empty($_GET['s'])){echo htmlspecialchars($_GET['s']);} ?>" placeholder="Rechercher un utilisateur" class="form-control" <?php if(!isset($_GET['s']) OR empty($_GET['s'])){ echo 'autofocus'; } ?>/> 
        <button class="btn" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
    </form>
    <?php include 'actions/users/sUsers.php'; ?>
    </div>
</body>
</html>