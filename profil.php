<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2025 Chromared
?>

<?php require 'actions/database.php';
    require 'actions/users/securityAction.php';
    if (isset($_GET['id']) AND !empty($_GET['id'])) { require 'actions/users/showOneUserProfilAction.php'; }else{ die('La variable URL contenant l\'ID de l\'utilisateur est absente ou vide.'); }
    require 'actions/functions/transfoGradeIntVersText.php';
    require 'actions/functions/conversionDateHour.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <?php include 'includes/header.php' ?>
</head>
<body>
    <?php include 'includes/navbar.php'?>
    <?php

    if($selectInfosFromUsers->rowCount() === 1){
?>
<div class="contour">
<div class="profil-info-page">
<div class="user-name"><br><h4><?= htmlspecialchars($usersInfos['prenom']); ?> <?= htmlspecialchars($usersInfos['nom']); ?></h4></div>
<div class="user-infos">
    <p>
        ID : <?= htmlspecialchars($usersInfos['id']); ?><br />
        Numéro de carte : <?= htmlspecialchars($usersInfos['carte']); ?><br />
        Classe : <?= htmlspecialchars($usersInfos['classe']); ?><br />
        Date d'inscription : Le <?php ConversionDateHour($usersInfos['datetime']); ?><br />
        Grade : <?php Grade($usersInfos['grade']); ?><br />
    </p>
    <div class="profil-part">
    <p>
        <?php if ($usersInfos['id'] == $_SESSION['id']){ ?>
            <button onclick="location.href='actions/users/logoutAction.php'">Se déconnecter</button>
            <button onclick="location.href='updateProfil.php?id=<?= htmlspecialchars($_SESSION['id']); ?>'">Modifier le compte</button>
        <?php } if($_SESSION['grade'] != 0 AND $_SESSION['id'] != $usersInfos['id']){ ?>
            <button onclick="location.href='gestion/update-user.php?id=<?= htmlspecialchars($usersInfos['id']) ?>'">Modifier cet utilisateur</button>
            <button onclick="location.href='gestion/user-emprunts.php?card=<?= htmlspecialchars($usersInfos['carte']) ?>'">Voir ses emprunts</button>
        <?php } ?>
    </p>
    </div>
</div>
</div>
<?php }else{ echo 'Aucun utilisateur avec l\'id n°' . htmlspecialchars($_GET['id']) . ' n\'a été trouvé.'; } ?>
</div>
</body>
</html>