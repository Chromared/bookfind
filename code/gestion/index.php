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
    <h1>Bienvenue sur la gestion du C.D.I <?php if($_SESSION['grade'] == '1'){?>et de BookFind<?php }else{echo'';} ?> !</h1>

</body>
</html>