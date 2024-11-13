<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2024 Chromared
?>

<?php require '../actions/database.php';
    require '../actions/users/securityAction.php';
    require 'actions/securityActionAdmin.php';
    require 'actions/books/addEmpruntAction.php';
    $dateDans30Jours = date('Y-m-d', strtotime('+30 days')); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enregistrer un emprunt</title>
    <?php include '../includes/header.php'; ?>
</head>
<body>
<?php include 'includes/navbar.php'; ?>
<?php if(isset($msg) AND (!empty($msg))){echo htmlspecialchars($msg);} ?>
<fieldset><legend>Ajouter un emprunt</legend>
<form method="post">
<label>N° de carte de l'emprunteur : </label><input type="number" name="card" min="0" max="99999999"/><br />
<label>À rendre pour le : </label><input type="date" value="<?php echo htmlspecialchars($dateDans30Jours); ?>" name="date" /><br />
<input type="hidden" name="id_book" value="<?= htmlspecialchars($_GET['id']); ?>" />
<input type="submit" name="validate" value="Ajouter l'emprunt"/>
</form>
</fieldset>
</body>
</html>