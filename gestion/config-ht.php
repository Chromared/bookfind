<?php require_once dirname(__DIR__) . '/includes/paths.php';
require_once ROOT_PATH . '/actions/functions/sessionInit.php'; ?>
<?php
//This file belongs to the BookFind project.
//Copyright (C) 2026 Chromared
//
//This program is free software: you can redistribute it and/or modify
//it under the terms of the GNU Affero General Public License as
//published by the Free Software Foundation, either version 3 of the
//License, or (at your option) any later version.
//
//This program is distributed in the hope that it will be useful,
//but WITHOUT ANY WARRANTY; without even the implied warranty of
//MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//GNU Affero General Public License for more details.
//
//You should have received a copy of the GNU Affero General Public License
//along with this program.  If not, see <https://www.gnu.org/licenses/>.
?>

<?php require ROOT_PATH . '/actions/users/securityAction.php';

// Reserved for the administrator (grade 1)
if (!isset($_SESSION['grade']) || $_SESSION['grade'] != '1') {
  http_response_code(403);
  require ROOT_PATH . '/errors/403.php';
  exit;
}

require ROOT_PATH . '/gestion/actions/users/securityAdminAction.php';
?>
<!DOCTYPE html>
<html lang="<?= $GLOBALS['bookfindLocale'] === 'fr_FR' ? 'fr' : 'en'; ?>" data-theme="<?php include ROOT_PATH . '/actions/users/decodeThemeAction.php'; ?>">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= bookfind_translate('BookFind — Configuration helper'); ?></title>
  <?php include ROOT_PATH . '/includes/header.php'; ?>
</head>

<body class="admin">
  <?php include ROOT_PATH . '/gestion/includes/navbar.php'; ?>
  <main class="page">
    <div class="container">
      <div class="narrow">
        <div class="card">
          <div class="card__body">
            <h1 class="card__title"><?= bookfind_translate('.ht file configuration'); ?></h1>
            <p class="text-subtle mono" style="font-size:13px;"><?php echo realpath(ROOT_PATH . '/gestion/config-ht.php'); ?></p>
            <?php
            if (isset($_POST['login']) and isset($_POST['pass'])) {
              $login = $_POST['login'];
              $pass_crypte = crypt($_POST['pass'], PASSWORD_DEFAULT);
              echo '<div class="alert alert--success"><svg class="icon"><use href="#i-check"/></svg><div>' . bookfind_translate('Line to copy into .htpasswd:') . '<br><span class="mono">' . $login . ':' . $pass_crypte . '</span></div></div>';
            }
            ?>
            <p class="text-subtle"><?= bookfind_translate('Enter your login and password to encrypt it.'); ?></p>
            <form action="<?= url(ltrim(str_replace(BASE_URL, '', $_SERVER['SCRIPT_NAME']), '/')) . (!empty($_SERVER['QUERY_STRING']) ? '?' . htmlspecialchars($_SERVER['QUERY_STRING'], ENT_QUOTES, 'UTF-8') : ''); ?>" method="post">
              <?= csrf_field(); ?>
              <div class="field">
                <label for="login" class="label"><?= bookfind_translate('Login'); ?></label>
                <input type="text" name="login" id="login" class="input">
              </div>
              <div class="field">
                <label for="pass" class="label"><?= bookfind_translate('Password'); ?></label>
                <input type="text" name="pass" id="pass" class="input">
              </div>
              <input type="submit" class="btn btn--primary" value="<?= bookfind_translate('Encrypt!'); ?>">
            </form>
          </div>
        </div>
      </div>
    </div>
  </main>
  <?php include ROOT_PATH . '/includes/footer.php'; ?>
</body>

</html>