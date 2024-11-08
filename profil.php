# This file belongs to the Bookfind project.
#
# Bookfind is distributed under the terms of the MIT software license.
#
# Copyright (C) 2024 Chromared

<?php require 'actions/database.php'; 
      require 'actions/users/securityAction.php';
      require 'actions/users/showOneUsersProfilAction.php';
      require 'actions/fonctions/transfoGradeIntVersText.php';
      require 'actions/fonctions/conversionDateHour.php'; ?>
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
    <?php if (isset($_GET['id'])) { ?>
    <?php

    if($selectInfosFromUsers->rowCount() >= 1){
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
    <?php if ($usersInfos['id'] == $_SESSION['id']){ ?>
    <p>
            <div class="profil-part">
            <button onclick="location.href='actions/users/logoutAction.php'">Se déconnecter</button>
            <button onclick="location.href='updateProfil.php?id=<?= htmlspecialchars($_SESSION['id']); ?>'">Modifier le compte</button>
            </div>
    </p>
    <?php } ?>
</div>
</div>
<?php }else{ echo '<div class="msg msg-blue>"Aucun utilisateur avec l\'id n°' . $_GET["id"] . ' n\'a été trouvé.</div>'; }} ?>
</div>
</body>
</html>