<?php
//This file belongs to the BookFind project.
//
//BookFind is distributed under the terms of the GNU Affero General Public License v3.0.
//
//Copyright (C) 2025 Chromared
?>

<?php $currentPage = basename($_SERVER['SCRIPT_NAME']);
// Landing page: minimal navbar (logo + sign in/sign up only)
// $isLanding = ($currentPage == 'index.php'); ?>
<nav class="navbar">
  <div class="navbar__inner">
    <a class="navbar__brand" href="index.php">
      <img src="/assets/logo.svg" alt="BookFind" class="navbar__logo">
      <span>BookFind</span>
    </a>
    <button class="navbar__toggle" type="button" data-nav-toggle="navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Open menu">
      <svg class="icon"><use href="#i-menu"/></svg>
    </button>
    <div class="navbar__nav" id="navbarNav">
      <?php // if (!$isLanding) { ?>
        <a class="navbar__link <?php if ($currentPage == 'books.php') { echo 'is-active'; } ?>" href="books.php">Search</a>
        <?php if (file_exists('configuration.php')) { ?>
          <a class="navbar__link <?php if ($currentPage == 'configuration.php') { echo 'is-active'; } ?>" href="configuration.php">Configure</a>
        <?php } ?>
      <?php // } ?>
      <?php if (!isset($_SESSION['auth'])) { ?>
        <a class="navbar__link navbar__link--auth <?php if ($currentPage == 'login.php') { echo 'is-active'; } ?>" href="login.php">Sign in</a>
        <?php if (file_exists('actions/users/signupAction.php') && file_exists('signup.php')) { ?>
          <a class="navbar__link navbar__link--cta navbar__link--auth <?php if ($currentPage == 'signup.php') { echo 'is-active'; } ?>" href="signup.php">Sign up</a>
        <?php } ?>
      <?php } elseif (isset($_SESSION['auth'])) { ?>
        <a class="navbar__link <?php if ($currentPage == 'profile.php') { echo 'is-active'; } ?>" href="profile.php?id=<?= htmlspecialchars($_SESSION['id']); ?>">Profile</a>
        <a class="navbar__link <?php if ($currentPage == 'settings.php') { echo 'is-active'; } ?>" href="settings.php?id=<?= htmlspecialchars($_SESSION['id']); ?>">Settings</a>
        <a class="navbar__link <?php if ($currentPage == 'loans.php') { echo 'is-active'; } ?>" href="loans.php?id=<?= htmlspecialchars($_SESSION['id']); ?>">Loans</a>
      <?php }
      if (isset($_SESSION['auth']) && $_SESSION['grade'] != 0) { ?>
        <a class="navbar__link" href="gestion/index.php">Management</a>
      <?php } ?>
    </div>
  </div>
</nav>
