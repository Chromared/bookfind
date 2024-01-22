<?php require 'actions/database.php'; 
      require 'actions/users/securityAction.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'includes/header.php' ?>
</head>
<body>
    <?php include 'includes/navbar.php'?>
    <?php
    $id = $_GET['id'];
    $selectInfosFromUsers= $bdd->prepare('SELECT * FROM users WHERE id = ?');
    $selectInfosFromUsers->execute(array($id));

    $usersInfos = $selectInfosFromUsers->fetch();
?>
<div class="contour">
<div class="user-name"><h4><?= $usersInfos['prenom']; ?> <?= $usersInfos['nom']; ?></h4></div>
<hr />
<div class="user-infos">
    <p>
        ID : <?= $usersInfos['id']; ?><br />
        Numéro de carte : <?= $usersInfos['carte']; ?><br />
        Classe : <?= $usersInfos['classe']; ?><br />
        Date d'inscription : <?php $timestamp = $usersInfos['inscription']; ?>
    </p>
</div>
</div>
</body>
</html>