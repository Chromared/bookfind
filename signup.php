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
<?php require_once __DIR__ . '/includes/paths.php';
require_once ROOT_PATH . '/actions/functions/sessionInit.php'; ?>

<?php require_once ROOT_PATH . '/actions/functions/sessionInit.php';
require ROOT_PATH . '/actions/database.php';
require ROOT_PATH . '/actions/functions/logFunction.php';
require ROOT_PATH . '/actions/functions/generateUsernameFunction.php';
require ROOT_PATH . '/actions/users/signupAction.php'; ?>
<!DOCTYPE html>
<html lang="<?= $GLOBALS['bookfindLocale'] === 'fr_FR' ? 'fr' : 'en'; ?>" data-theme="<?php include ROOT_PATH . '/actions/users/decodeThemeAction.php'; ?>">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= bookfind_translate('BookFind — Sign up'); ?></title>
  <?php include ROOT_PATH . '/includes/header.php'; ?>
</head>

<body>
  <?php include ROOT_PATH . '/includes/icons.php'; ?>
  <div class="auth">
    <aside class="auth__brand">
      <div class="auth__brand-top">
        <img src="<?= asset('assets/logo.svg'); ?>" alt="BookFind" class="navbar__logo">
        BookFind
      </div>
      <div>
        <h2><?= bookfind_translate('Join the C.D.I. library.'); ?></h2>
        <p><?= bookfind_translate('One account is all you need to browse the catalog and track your loans.'); ?></p>
        <div class="auth__points">
          <div class="auth__point">
            <svg class="icon"><use href="#i-book"/></svg>
            <div><b><?= bookfind_translate('Full catalog'); ?></b><br><span><?= bookfind_translate('all the C.D.I. books, up to date.'); ?></span></div>
          </div>
          <div class="auth__point">
            <svg class="icon"><use href="#i-arrow-up"/></svg>
            <div><b><?= bookfind_translate('Personal loans'); ?></b><br><span><?= bookfind_translate('your due dates and returns at a glance.'); ?></span></div>
          </div>
          <div class="auth__point">
            <svg class="icon"><use href="#i-grid"/></svg>
            <div><b><?= bookfind_translate('Clean interface'); ?></b><br><span><?= bookfind_translate('dark by default, light on demand.'); ?></span></div>
          </div>
        </div>
      </div>
      <div class="auth__foot">© 2026 BookFind by Chromared</div>
    </aside>

    <div class="auth__form">
      <div class="auth__form-inner">
        <h1><?= bookfind_translate('Sign up'); ?></h1>
        <p class="text-subtle mb-4"><?= bookfind_translate('Create your student or teacher account.'); ?></p>

        <?php if (isset($errorMsg)) { ?>
          <div class="alert alert--warning" role="alert">
            <svg class="icon"><use href="#i-alert"/></svg>
            <div><?= $errorMsg; ?></div>
          </div>
        <?php } ?>

        <form action="<?= url(ltrim(str_replace(BASE_URL, '', $_SERVER['SCRIPT_NAME']), '/')) . (!empty($_SERVER['QUERY_STRING']) ? '?' . htmlspecialchars($_SERVER['QUERY_STRING'], ENT_QUOTES, 'UTF-8') : ''); ?>" method="POST">
          <div class="form-row">
            <div class="field">
              <label for="firstname" class="label"><?= bookfind_translate('First name'); ?></label>
              <input type="text" name="firstname" id="firstname" class="input" placeholder="John" required />
            </div>
            <div class="field">
              <label for="lastname" class="label"><?= bookfind_translate('Last name'); ?></label>
              <input type="text" name="lastname" id="lastname" class="input" placeholder="Doe" required />
            </div>
          </div>
          <div class="field">
            <label for="class_name" class="label"><?= bookfind_translate('Class'); ?></label>
            <select name="class_name" id="class_name" class="select" required>
              <option value><?= bookfind_translate('--- Select a class ---'); ?></option>
              <?php include ROOT_PATH . '/actions/functions/getClassesAndOptions.php'; ?>
            </select>
          </div>
          <div class="field">
            <label for="password" class="label"><?= bookfind_translate('Password'); ?></label>
            <input type="password" name="password" id="password" class="input" required />
          </div>
          <div class="field">
            <label for="confirm_password" class="label"><?= bookfind_translate('Confirm password'); ?></label>
            <input type="password" name="confirm_password" id="confirm_password" class="input" required />
          </div>
          <div class="field">
            <label class="check">
              <input type="checkbox" name="rules-pdc" id="rules-pdc" required />
              <span><?= bookfind_translate('I have read and accept the'); ?> <a href="<?= url('rules.php'); ?>" target="_blank"><?= bookfind_translate('rules'); ?></a> <?= bookfind_translate('and the'); ?> <a href="<?= url('privacy.php'); ?>" target="_blank"><?= bookfind_translate('privacy policy'); ?></a></span>
            </label>
          </div>
          <div class="field">
            <?= csrf_field(); ?>
            <input type="submit" name="validate" class="btn btn--primary btn--block btn--lg" value="<?= bookfind_translate('Sign up'); ?>" />
          </div>
        </form>

        <div class="auth__foot-link"><?= bookfind_translate('Already signed up?'); ?> <a href="<?= url('login.php'); ?>"><?= bookfind_translate('Sign in'); ?></a></div>
      </div>
    </div>
  </div>
</body>

</html>
