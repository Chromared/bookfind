<?php
//This file belongs to the BookFind project.
//
//BookFind is distributed under the terms of the GNU Affero General Public License v3.0.
//
//Copyright (C) 2025 Chromared
?>

<?php require 'actions/functions/sessionInit.php';
require 'actions/database.php';
require 'actions/functions/logFunction.php';
require 'actions/functions/generateUsernameFunction.php';
require 'actions/users/signupAction.php'; ?>
<!DOCTYPE html>
<html lang="en" data-theme="<?php include 'actions/users/decodeThemeAction.php'; ?>">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BookFind — Sign up</title>
  <?php include 'includes/header.php'; ?>
</head>

<body>
  <?php include 'includes/icons.php'; ?>
  <div class="auth">
    <aside class="auth__brand">
      <div class="auth__brand-top">
        <img src="/assets/logo.svg" alt="BookFind" class="navbar__logo">
        BookFind
      </div>
      <div>
        <h2>Join the C.D.I. library.</h2>
        <p>One account is all you need to browse the catalog and track your loans.</p>
        <div class="auth__points">
          <div class="auth__point">
            <svg class="icon"><use href="#i-book"/></svg>
            <div><b>Full catalog</b><br><span>all the C.D.I. books, up to date.</span></div>
          </div>
          <div class="auth__point">
            <svg class="icon"><use href="#i-arrow-up"/></svg>
            <div><b>Personal loans</b><br><span>your due dates and returns at a glance.</span></div>
          </div>
          <div class="auth__point">
            <svg class="icon"><use href="#i-grid"/></svg>
            <div><b>Clean interface</b><br><span>dark by default, light on demand.</span></div>
          </div>
        </div>
      </div>
      <div class="auth__foot">© 2026 BookFind by Chromared</div>
    </aside>

    <div class="auth__form">
      <div class="auth__form-inner">
        <h1>Sign up</h1>
        <p class="text-subtle mb-4">Create your student or teacher account.</p>

        <?php if (isset($errorMsg)) { ?>
          <div class="alert alert--warning" role="alert">
            <svg class="icon"><use href="#i-alert"/></svg>
            <div><?= $errorMsg; ?></div>
          </div>
        <?php } ?>

        <form method="POST">
          <div class="form-row">
            <div class="field">
              <label for="firstname" class="label">First name</label>
              <input type="text" name="firstname" id="firstname" class="input" placeholder="John" required />
            </div>
            <div class="field">
              <label for="lastname" class="label">Last name</label>
              <input type="text" name="lastname" id="lastname" class="input" placeholder="Doe" required />
            </div>
          </div>
          <div class="field">
            <label for="class_name" class="label">Class</label>
            <select name="class_name" id="class_name" class="select" required>
              <option value>--- Select a class ---</option>
              <?php include 'actions/functions/getClassesAndOptions.php'; ?>
            </select>
          </div>
          <div class="field">
            <label for="password" class="label">Password</label>
            <input type="password" name="password" id="password" class="input" required />
          </div>
          <div class="field">
            <label for="confirm_password" class="label">Confirm password</label>
            <input type="password" name="confirm_password" id="confirm_password" class="input" required />
          </div>
          <div class="field">
            <label class="check">
              <input type="checkbox" name="rules-pdc" id="rules-pdc" required />
              <span>I have read and accept the <a href="rules.php" target="_blank">rules</a> and the <a href="privacy.php" target="_blank">privacy policy</a></span>
            </label>
          </div>
          <div class="field">
            <?= csrf_field(); ?>
            <input type="submit" name="validate" class="btn btn--primary btn--block btn--lg" value="Sign up" />
          </div>
        </form>

        <div class="auth__foot-link">Already signed up? <a href="login.php">Sign in</a></div>
      </div>
    </div>
  </div>
</body>

</html>
