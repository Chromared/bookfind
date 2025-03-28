<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2025 Chromared
?>

<?php if(isset($_GET['id']) AND !empty($_GET['id'])){ ?>
<?php require '../actions/database.php'; 
    require 'actions/users/securityAction.php';
    require 'actions/users/securityAdminAction.php';
    require '../actions/functions/logFunction.php';
    require '../actions/users/showOneUserProfilAction.php';
    require '../actions/functions/selected.php';
    require '../actions/functions/transfoGradeIntVersText.php';
    require 'actions/users/updateInfoPersoAction.php';
    require 'actions/users/updateInfoScoAction.php';
    require 'actions/users/updateGradeAction.php';
    require 'actions/users/updateMdpAction.php';
    require 'actions/users/deleteAccountAction1.php';
    require 'actions/users/deleteAccountAction2.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mise à jour d'un compte utilisateur</title>
    <?php include '../includes/header.php' ?>
</head>
<body>
<?php include 'includes/navbar.php'?>

<?php if(($_SESSION['grade'] != '1' AND $usersInfos['grade'] == '1') OR ($_SESSION['grade'] != '1' AND $_SESSION['grade'] != '2' AND $usersInfos['grade'] == '2')){echo '<p>Vous n\'avez pas le droit de modifier cet utilisateur.</p>';}else{ ?>

<?php if(isset($msg)){ echo '<p>' . $msg . '</p>'; } ?>
<p>
<hr>
<div class="update-part">
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
    <label class="form-label">Classe :</label> <select class="form-control" name="classe"><?php include '../actions/functions/recupClassesAndOptions.php'; ?></select>
    <input type="submit" class="form-btn-blue" name="validateInfoSco" value="Valider" />
</form>
</div>
<hr>
<div class="update-part">
<?php if($_SESSION['grade'] == '1' OR $_SESSION['grade'] == '2'){?>
<h4>Grade</h4>
<form method="post" class="form">
    <label class="form-label">Grade :</label> <select class="form-control" name="grade" ><option value="0" <?php Selected('0', $usersInfos['grade']); ?> >Aucun</option><option value="3" <?php Selected('3', $usersInfos['grade']); ?> >Assistant</option><option value="2" <?php Selected('2', $usersInfos['grade']); ?> >Gérant</option><?php if($_SESSION['grade'] == '1'){ ?><option value="1" <?php Selected('1', $usersInfos['grade']); ?> >Administrateur</option><?php } ?></select>
    <input type="submit" class="form-btn-blue" name="validateGrade" value="Valider" />
</form>
</div>
<?php } ?>
<hr>
<?php if($_SESSION['grade'] == '1' OR $_SESSION['grade'] == '2'){ ?>
<div class="update-part">
</h4>Mot de passe</h4>
<form method="post" class="form">
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
    <input type="submit" value="Supprimer le compte" name="validateDelete1" class="form-btn-orange" />
</form>
<?php }elseif(isset($deleteAccount)){ ?>
<form class="form" method="POST">
    <label class="form-label">Je confirme vouloir supprimer ce compte (Attention ! Cette action est irreversible.) : </label> <input type="checkbox" name="confirm-delete" class="form-checkbox" />
    <input type="submit" value="Supprimer le compte" name="validateDelete2" class="form-btn-red" />
</form>
<?php }?>
</div>
<?php } ?>
</p>
<?php } ?>
</body>
</html>
<?php } ?>