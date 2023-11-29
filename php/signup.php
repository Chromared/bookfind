<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'includes/header.php'; ?>
</head>
<body>
<?php include 'includes/navbar.php'; ?>
<form method="POST" class="form">
    <p>
    <label class="form-label">Nom : </label><input type="text" name="name" required="required" class="form-control"/>
    <br /><label class="form-label">Prénom : </label><input type="text" name="firstname" required="required" class="form-control"/>
    <br /><label class="form-label">Numéro de carte : </label><input type="number" maxlength="8" max="99999999" required="required" name="number-card" class="form-control"/>
    <br /><label class="form-label">Classe : </label><input type="text" maxlength="2" name="class" required="required" class="form-control"/>
    <br /><button class="btn" type="submit">Rechercher</button>
    </p>
</form>
</body>
</html>