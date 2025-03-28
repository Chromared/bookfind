<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2025 Chromared
?>



<?php require '../actions/database.php';
    require 'actions/users/securityAction.php';
    require 'actions/users/securityAdminAction.php';
    require '../actions/functions/logFunction.php';
    require 'actions/others/updateDatabase.php';
    require 'actions/others/addClasse.php';
    require 'actions/others/updateClasse.php';
    require 'actions/others/deleteClasse.php';
    if($_SESSION['grade'] != '1'){header('Location: index.php'); exit;} ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer BookFind</title>
    <?php include '../includes/header.php'; ?>
</head>
<body>
    <?php include 'includes/navbar.php'; ?>
    <h2>Base de donnée</h2>
    <h3>Identifiants de connexion</h3>
    <form method="post">
        <label for="host">Hôte : </label><input type="text" id="host" name="host" value="<?= $host; ?>" required /><br />
        <label for="dbname">Nom de la base de donnée : </label><input type="text" id="dbname" name="dbname" value="<?= $dbname; ?>" required /><br />
        <label for="user">Nom d'utilisateur : </label><input type="text" id="user" name="user" value="<?= $username; ?>" required /><br />
        <label for="password">Mot de passe : </label><input type="password" id="password" name="password" value="<?= $password; ?>" placeholder="Aucun mot de passe" /><br />
        <input type="submit" name="databaseValidate" value="Enregistrer">
    </form>

    <h2>Gérer les classes</h2>

    <h3>Ajouter une classe</h3>
    <p><?php if(isset($msgC1)){ echo $msgC1; } ?>
    <form method="post">
        <label for="newClasse">Nom de la classe : </label><input type="text" id="newClasse" name="newClasse" required /><br />
        <input type="submit" name="classeAddValidate" value="Ajouter">
    </form></p>
    
    <h3>Modifier une classe</h3>
    <p><?php if(isset($msgC2)){ echo $msgC2; } ?>
    <form method="post">
    <label for="existingClasse">Classe à modifier : </label><select class="form-control" name="existingClasse" id="existingClasse" required><option value>--- Sélectionner une classe ---</option><?php include '../actions/functions/recupClassesAndOptions.php'; ?></select><br />
    <label for="newClasseName">Nouveau nom de la classe : </label><input type="text" id="newClasseName" name="newClasseName" required /><br />
    <input type="submit" name="classeUpdateValidate" value="Modifier">
    </form></p>    

    <h3>Supprimer une classe</h3>
    <p><?php if(isset($msgC3)){ echo $msgC3; } ?>
    <form method="post">
    <label for="existingClasse2">Classe à supprimer : </label><select class="form-control" name="existingClasse2" id="existingClasse2" required><option value>--- Sélectionner une classe ---</option><?php include '../actions/functions/recupClassesAndOptions.php'; ?></select><br />
    <input type="submit" name="classeDeleteValidate" value="Supprimer">
    </form></p>
</body>
</html>