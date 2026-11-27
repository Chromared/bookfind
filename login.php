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

<?php require 'actions/functions/sessionInit.php'; ?>
<?php require 'actions/database.php';
require 'actions/functions/logFunction.php';
require 'actions/functions/csrfFunction.php';
require 'actions/users/loginAction.php'; ?>
<!DOCTYPE html>
<html lang="<?= $GLOBALS['bookfindLocale'] === 'fr_FR' ? 'fr' : 'en'; ?>" data-theme="<?php include 'actions/users/decodeThemeAction.php'; ?>">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= bookfind_translate('BookFind — Sign in'); ?></title>
  <?php include 'includes/header.php'; ?>
</head>

<body>
  <?php include 'includes/icons.php'; ?>
  <div class="auth">
    <aside class="auth__brand">
      <a href="index.php" class="auth__back" aria-label="<?= bookfind_translate('Back'); ?>" title="<?= bookfind_translate('Back'); ?>"
         onclick="if (history.length > 1) { history.back(); return false; }">
        <svg class="icon"><use href="#i-arrow-left"/></svg>
      </a>
      <div>
        <h2><?= bookfind_translate('The C.D.I. library, simple and modern.'); ?></h2>
        <p><?= bookfind_translate("Search, borrow and track your school's books from a single place."); ?></p>
        <div class="auth__points">
          <div class="auth__point">
            <svg class="icon"><use href="#i-search"/></svg>
            <div><b><?= bookfind_translate('Instant search'); ?></b><br><span><?= bookfind_translate('by title, author, ISBN, genre or series.'); ?></span></div>
          </div>
          <div class="auth__point">
            <svg class="icon"><use href="#i-book"/></svg>
            <div><b><?= bookfind_translate('Tracked loans'); ?></b><br><span><?= bookfind_translate('due dates and returns, with overdue alerts.'); ?></span></div>
          </div>
          <div class="auth__point">
            <svg class="icon"><use href="#i-people"/></svg>
            <div><b><?= bookfind_translate('Centralized management'); ?></b><br><span><?= bookfind_translate('books, users and logs for managers.'); ?></span></div>
          </div>
        </div>
      </div>
      <div class="auth__foot">© 2026 BookFind by Chromared</div>
    </aside>

    <div class="auth__form">
      <div class="auth__form-inner">
        <a href="index.php" class="auth__back auth__back--mobile" aria-label="<?= bookfind_translate('Back'); ?>" title="<?= bookfind_translate('Back'); ?>"
           onclick="if (history.length > 1) { history.back(); return false; }">
          <svg class="icon"><use href="#i-arrow-left"/></svg>
        </a>
        <h1><?= bookfind_translate('Sign in'); ?></h1>
        <p class="text-subtle mb-4"><?= bookfind_translate('Access your BookFind space.'); ?></p>

        <?php if (isset($errorMsg)) { ?>
          <div class="alert alert--warning" role="alert">
            <svg class="icon"><use href="#i-alert"/></svg>
            <div><?= $errorMsg; ?></div>
          </div>
        <?php } ?>

        <form method="POST">
          <div class="field">
            <label for="username" class="label"><?= bookfind_translate('Username'); ?></label>
            <input type="text" name="username" id="username" class="input" placeholder="jdoe" autofocus required />
          </div>
          <div class="field">
            <label for="password" class="label"><?= bookfind_translate('Password'); ?></label>
            <input type="password" name="password" id="password" class="input" required />
          </div>
          <div class="field">
            <label class="check">
              <input type="checkbox" name="rememberMe" id="rememberMe" />
              <span><?= bookfind_translate('Remember me'); ?></span>
            </label>
          </div>
          <?= csrf_field(); ?>
          <?php if (isset($_GET['redirect']) and !empty($_GET['redirect'])) { ?>
            <input type="hidden" name="redirect" value="<?= htmlspecialchars($_GET['redirect']); ?>" />
          <?php } ?>
          <div class="field">
            <input type="submit" name="validate" class="btn btn--primary btn--block btn--lg" value="<?= bookfind_translate('Sign in'); ?>" />
          </div>
        </form>

        <div class="auth__foot-link"><?= bookfind_translate("Don't have an account yet?"); ?> <a href="signup.php"><?= bookfind_translate('Sign up'); ?></a></div>
      </div>
    </div>
  </div>
</body>

</html>
