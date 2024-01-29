<?php require 'actions/database.php'; 
      require 'actions/users/securityAction.php';
      require 'actions/users/securityGetIdProfil.php';
      require 'actions/users/showOneUsersProfilAction.php';
      require 'actions/fonctions/selectedClasse.php';
      //require '';
      //require '';
      //require ''; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'includes/header.php' ?>
</head>
<body>
<?php include 'includes/navbar.php'?>
<fieldset><legend>Informations personnelle</legend>
<form method="POST">
    <label>Prénom :</label> <input type="text" value="<?= $usersInfos['prenom'] ?>" /><br />
    <label>Nom :</label> <input type="text" value="<?= $usersInfos['nom'] ?>" /><br />
    <input type="submit" value="Modifier" name="validateInfoPerso" />
</form>
</fieldset>
<fieldset><legend>Informations scolaire</legend>
<form method="post">
    <label>Carte :</label> <input type="number" value="<?= $usersInfos['carte'] ?>" />
    <label class="form-label">Classe :</label> <select class="form-control" name="classe" required="required" ><option value="6B">6B</option><option value="5B">5B</option><option value="4B">4B</option><option value="3B">3B</option><option value="6R">6R</option><option value="5R">5R</option><option value="4R">4R</option><option value="3R">3R</option><option value="6J">6J</option><option value="5J">5J</option><option value="4J">4J</option><option value="3J">3J</option><option value="6V">6V</option><option value="5V">5V</option><option value="4V">4V</option><option value="3V">3V</option></select>
</form>
</fieldset>
</body>
</html>