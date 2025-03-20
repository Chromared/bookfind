<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2024 Chromared
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
    <?php include 'includes/navbar.php'; 
    if(isset($_GET['where']) AND !empty($_GET['where'])){ $getwhere = $_GET['where'];}else{$getwhere = NULL;}
    function Selected($where, $value){if(isset($where) AND !empty($where) AND $where == $value){echo htmlspecialchars('selected');}} ?>
        <div class="usersgestion-part">
    <form method="GET" class="form">
        <br /><input type="search" name="s" value="<?php if(isset($_GET['s']) AND !empty($_GET['s'])){echo htmlspecialchars($_GET['s']);} ?>" placeholder="Rechercher un utilisateur" class="form-control" /> 
        <select name="where"><option <?php Selected($getwhere, 'carte'); ?> value="carte">Carte</option><option <?php Selected($getwhere, 'id'); ?> value="id">ID</option><option <?php Selected($getwhere, 'classe'); ?> value="classe">Classe</option><option <?php Selected($getwhere, 'nom'); ?> value="nom">Nom</option><option <?php Selected($getwhere, 'prenom'); ?> value="prenom">Prénom</option><option <?php Selected($getwhere, 'grade'); ?> value="grade">Grade</option></select>
        <button class="btn" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
    </form>
    <?php include 'actions/users/sUsers.php'; ?>
    </div>
</body>
</html>