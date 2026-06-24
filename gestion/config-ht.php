<?php
//This file belongs to the BookFind project.
//
//BookFind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2025 Chromared
?>



<?php require '../actions/users/securityAction.php';
require 'actions/users/securityAdminAction.php';
?>
<!DOCTYPE html>
<html lang="fr" data-bs-theme="<?php include '../actions/users/decodeThemeAction.php'; ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Outils d'aide à la configuration des fichiers .ht</title>
    <?php include '../includes/header.php'; ?>
</head>

<body class="d-flex flex-column min-vh-100">
    <p>
        <?php echo realpath('config-ht.php'); ?><br /><br />
        <?php
        if (isset($_POST['login']) and isset($_POST['pass'])) {
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
    <?php include '../includes/footer.php'; ?>
</body>

</html>