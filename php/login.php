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
    <label class="form-label">Numéro de carte : </label><input type="number" max="99999999" required="required" name="card" class="form-control" />
</form>
</body>
</html>