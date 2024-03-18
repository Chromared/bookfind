<?php require '../actions/database.php'; 
      require '../actions/users/securityAction.php';?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include '../includes/header.php'; ?>
</head>
<body>
<?php include 'includes/navbar.php'; ?>
<form method="GET" class="form">
        <input type="search" name="s" class="form-control" />
        <button class="btn" type="submit">Rechercher</button>
    </form>
    <?php include 'actions/users/sUsers.php'; ?>
</body>
</html>