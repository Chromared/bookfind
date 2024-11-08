# X11 License
# Copyright © 2024 Chromared


<?php require '../actions/users/securityAction.php';
      require 'actions/securityActionAdmin.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Outils d'aide à la configuration des fichiers .ht</title>
    <?php include '../includes/header.php'; ?>
</head>
<body>
<p>
<?php echo realpath('config-ht.php'); ?><br /><br />
 <?php
    if (isset($_POST['login']) AND isset($_POST['pass']))
    {
    $login = $_POST['login'];
    $pass_crypte = crypt($_POST['pass'], PASSWORD_DEFAULT);
    echo 'Ligne à copier dans le .htpasswd :<br />' . $login . ':' .
    $pass_crypte;
    }
    ?>
    </p>
    <p>Entrez votre login et votre mot de passe pour le crypter.</p>
    <form method="post">
    <p>
    Login : <input type="text" name="login"><br />
    Mot de passe : <input type="text" name="pass"><br /><br />
    <input type="submit" value="Crypter !">
    </p>
    </form>
</body>
</html>