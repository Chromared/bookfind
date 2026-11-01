<?php
//This file belongs to the BookFind project.
//
//BookFind is distributed under the terms of the GNU Affero General Public License v3.0.
//
//Copyright (C) 2025 Chromared
?>

<?php require '../actions/users/securityAction.php';

// Reserved for the administrator (grade 1)
if (!isset($_SESSION['grade']) || $_SESSION['grade'] != '1') {
    http_response_code(403);
    require '../errors/403.php';
    exit;
}

require 'actions/users/securityAdminAction.php';
?>
<!DOCTYPE html>
<html lang="en" data-theme="<?php include '../actions/users/decodeThemeAction.php'; ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookFind — Configuration helper</title>
    <?php include '../includes/header.php'; ?>
</head>

<body class="admin">
    <?php include 'includes/navbar.php'; ?>
    <main class="page">
      <div class="container">
        <div class="narrow">
          <div class="card">
            <div class="card__body">
              <h1 class="card__title">.ht file configuration</h1>
              <p class="text-subtle mono" style="font-size:13px;"><?php echo realpath('config-ht.php'); ?></p>
              <?php
              if (isset($_POST['login']) and isset($_POST['pass'])) {
                  $login = $_POST['login'];
                  $pass_crypte = crypt($_POST['pass'], PASSWORD_DEFAULT);
                  echo '<div class="alert alert--success"><svg class="icon"><use href="#i-check"/></svg><div>Line to copy into .htpasswd:<br><span class="mono">' . $login . ':' . $pass_crypte . '</span></div></div>';
              }
              ?>
              <p class="text-subtle">Enter your login and password to encrypt it.</p>
              <form method="post">
                  <?= csrf_field(); ?>
                  <div class="field">
                      <label for="login" class="label">Login</label>
                      <input type="text" name="login" id="login" class="input">
                  </div>
                  <div class="field">
                      <label for="pass" class="label">Password</label>
                      <input type="text" name="pass" id="pass" class="input">
                  </div>
                  <input type="submit" class="btn btn--primary" value="Encrypt!">
              </form>
            </div>
          </div>
        </div>
      </div>
    </main>
    <?php include '../includes/footer.php'; ?>
</body>

</html>
