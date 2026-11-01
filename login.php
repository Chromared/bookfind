<?php
//This file belongs to the BookFind project.
//
//BookFind is distributed under the terms of the GNU Affero General Public License v3.0.
//
//Copyright (C) 2025 Chromared
?>

<?php require 'actions/functions/sessionInit.php'; ?>
<?php require 'actions/database.php';
require 'actions/functions/logFunction.php';
require 'actions/functions/csrfFunction.php';
require 'actions/users/loginAction.php'; ?>
<!DOCTYPE html>
<html lang="en" data-theme="<?php include 'actions/users/decodeThemeAction.php'; ?>">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BookFind — Sign in</title>
  <?php include 'includes/header.php'; ?>
</head>

<body>
  <?php include 'includes/icons.php'; ?>
  <div class="auth">
    <aside class="auth__brand">
      <a href="index.php" class="auth__back" aria-label="Back" title="Back"
         onclick="if (history.length > 1) { history.back(); return false; }">
        <svg class="icon"><use href="#i-arrow-left"/></svg>
      </a>
      <div>
        <h2>The C.D.I. library, simple and modern.</h2>
        <p>Search, borrow and track your school's books from a single place.</p>
        <div class="auth__points">
          <div class="auth__point">
            <svg class="icon"><use href="#i-search"/></svg>
            <div><b>Instant search</b><br><span>by title, author, ISBN, genre or series.</span></div>
          </div>
          <div class="auth__point">
            <svg class="icon"><use href="#i-book"/></svg>
            <div><b>Tracked loans</b><br><span>due dates and returns, with overdue alerts.</span></div>
          </div>
          <div class="auth__point">
            <svg class="icon"><use href="#i-people"/></svg>
            <div><b>Centralized management</b><br><span>books, users and logs for managers.</span></div>
          </div>
        </div>
      </div>
      <div class="auth__foot">© 2026 BookFind by Chromared</div>
    </aside>

    <div class="auth__form">
      <div class="auth__form-inner">
        <a href="index.php" class="auth__back auth__back--mobile" aria-label="Back" title="Back"
           onclick="if (history.length > 1) { history.back(); return false; }">
          <svg class="icon"><use href="#i-arrow-left"/></svg>
        </a>
        <h1>Sign in</h1>
        <p class="text-subtle mb-4">Access your BookFind space.</p>

        <?php if (isset($errorMsg)) { ?>
          <div class="alert alert--warning" role="alert">
            <svg class="icon"><use href="#i-alert"/></svg>
            <div><?= $errorMsg; ?></div>
          </div>
        <?php } ?>

        <form method="POST">
          <div class="field">
            <label for="username" class="label">Username</label>
            <input type="text" name="username" id="username" class="input" placeholder="jdoe" autofocus required />
          </div>
          <div class="field">
            <label for="password" class="label">Password</label>
            <input type="password" name="password" id="password" class="input" required />
          </div>
          <div class="field">
            <label class="check">
              <input type="checkbox" name="rememberMe" id="rememberMe" />
              <span>Remember me</span>
            </label>
          </div>
          <?= csrf_field(); ?>
          <?php if (isset($_GET['redirect']) and !empty($_GET['redirect'])) { ?>
            <input type="hidden" name="redirect" value="<?= htmlspecialchars($_GET['redirect']); ?>" />
          <?php } ?>
          <div class="field">
            <input type="submit" name="validate" class="btn btn--primary btn--block btn--lg" value="Sign in" />
          </div>
        </form>

        <div class="auth__foot-link">Don't have an account yet? <a href="signup.php">Sign up</a></div>
      </div>
    </div>
  </div>
</body>

</html>
