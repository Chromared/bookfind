<?php require '../actions/database.php'; 
      require '../actions/users/securityAction.php';
      require 'actions/securityActionAdmin.php';?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include '../includes/header.php'; ?>
</head>
<body>
    <?php include 'includes/navbar.php'; ?>
        <div class="usersgestion-part">
    <form method="GET" class="form">
        <br><input type="search" name="s" class="form-control" />
        <button class="btn" type="submit"><i class="fa-solid fa-magnifying-glass fa-beat" style="color: snow;"></i></button>
    </form>
    <?php include 'actions/users/sUsers.php'; ?>
    </div>
</body>
</html>