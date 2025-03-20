<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2024 Chromared
?>
    
<?php if(isset($_GET['id']) AND !empty($_GET['id'])){ ?>
<?php require 'actions/database.php';
    require 'actions/functions/logFunction.php';
    require 'actions/users/securityAction.php';
    require 'actions/users/showOneUsersProfilAction.php';
    require 'actions/functions/selected.php';
    require 'actions/users/updateInfoPersoAction.php';
    require 'actions/users/updateInfoScoAction.php';
    require 'actions/users/updateMdpAction.php';
    require 'actions/users/deleteAccountAction1.php';
    require 'actions/users/deleteAccountAction2.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mise à jour du compte</title>
    <?php include 'includes/header.php' ?>
</head>
<body>
<?php include 'includes/navbar.php'?>
<?php if(isset($_GET['msg']) AND $_GET['msg'] == 'true'){ echo '<p>Vos modifications ont bien été enregistré.</p>'; } if(isset($msg)){ echo '<p>' . $msg . '</p>'; } ?>
<div class="update-part">
<p>
<h4>Informations personnelle</h4>
<form method="POST" class="form">
    <label class="form-label">Prénom :</label> <input name="firstname" class="form-control" type="text" value="<?= htmlspecialchars($usersInfos['prenom']); ?>" />
    <label class="form-label">Nom :</label> <input name="name" type="text" class="form-control" value="<?= htmlspecialchars($usersInfos['nom']); ?>" />
    <input type="submit" class="form-btn-blue" value="Valider" name="validateInfoPerso" />
</form>
</div>
<hr>
<div class="update-part">
<h4>Informations scolaire</h4>
<form method="post" class="form">
    <label class="form-label">Carte :</label> <input class="form-control" name="card" type="number" value="<?= htmlspecialchars($usersInfos['carte']); ?>" />
    <label class="form-label">Classe :</label> <select class="form-control" name="classe"><?php include 'actions/functions/recupClassesAndOptions.php'; ?></select>
    <input type="submit" class="form-btn-blue" name="validateInfoSco" value="Valider" />
</form>
</div>
<hr>
<div class="update-part">
<h4>Mot de passe</h4>
<form method="post" class="form">
    <label class="form-label">Mot de passe actuel :</label> <input type="password" name="actual-password" class="form-control" />
    <label class="form-label">Nouveau mot de passe :</label> <input type="password" name="new-password" class="form-control" />
    <label class="form-label">Confirmer le nouveau mot de passe :</label> <input type="password" name="confirm-new-password" class="form-control" />
    <input class="form-btn-blue" value="Valider" name="validateMdp" type="submit" />
</form>
</div>
<hr>
<div class="update-part">
<h4>Supprimer le compte</h4>
<?php if(!isset($deleteAccount)){ ?>
<form class="form" method="POST">
    <label class="form-label">Mot de passe :</label> <input type="password" name="password" class="form-control" />
    <input type="submit" value="Supprimer le compte" name="validateDelete1" class="form-btn-orange" />
</form>
<?php }elseif(isset($deleteAccount)){ ?>
<form class="form" method="POST">
    <label class="form-label">Je confirme vouloir supprimer mon compte (Attention ! Cette action est irreversible.):</label> <input type="checkbox" name="confirm-delete" class="form-checkbox" />
    <input type="submit" value="Supprimer le compte" name="validateDelete2" class="form-btn-red" />
</form>
<?php }?>
</p>
</div>
</body>
</html>
<?php } ?>