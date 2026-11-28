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

<?php $currentPage = basename($_SERVER['SCRIPT_NAME']);
// Landing page: minimal navbar (logo + sign in/sign up only)
// $isLanding = ($currentPage == 'index.php'); 
?>
<nav class="navbar">
  <div class="navbar__inner">
    <a class="navbar__brand" href="<?= url('index.php'); ?>">
      <img src="<?= asset('assets/logo.svg'); ?>" alt="BookFind" class="navbar__logo">
      <span>BookFind</span>
    </a>
    <button class="navbar__toggle" type="button" data-nav-toggle="navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="<?= bookfind_translate('Open menu'); ?>">
      <svg class="icon">
        <use href="#i-menu" />
      </svg>
    </button>
    <div class="navbar__nav" id="navbarNav">
      <?php // if (!$isLanding) { 
      ?>
      <a class="navbar__link <?php if ($currentPage == 'books.php') {
                                echo 'is-active';
                              } ?>" href="<?= url('books.php'); ?>"><?= bookfind_translate('Search'); ?></a>
      <?php if (file_exists(ROOT_PATH . '/configuration.php')) { ?>
        <a class="navbar__link <?php if ($currentPage == 'configuration.php') {
                                  echo 'is-active';
                                } ?>" href="<?= url('configuration.php'); ?>"><?= bookfind_translate('Configure'); ?></a>
      <?php } ?>
      <?php // } 
      ?>
      <?php if (!isset($_SESSION['auth'])) { ?>
        <a class="navbar__link navbar__link--auth <?php if ($currentPage == 'login.php') {
                                                    echo 'is-active';
                                                  } ?>" href="<?= url('login.php'); ?>"><?= bookfind_translate('Sign in'); ?></a>
        <?php if (file_exists(ROOT_PATH . '/actions/users/signupAction.php') && file_exists(ROOT_PATH . '/signup.php')) { ?>
          <a class="navbar__link navbar__link--cta navbar__link--auth <?php if ($currentPage == 'signup.php') {
                                                                        echo 'is-active';
                                                                      } ?>" href="<?= url('signup.php'); ?>"><?= bookfind_translate('Sign up'); ?></a>
        <?php } ?>
      <?php } elseif (isset($_SESSION['auth'])) { ?>
        <a class="navbar__link <?php if ($currentPage == 'profile.php') {
                                  echo 'is-active';
                                } ?>" href="<?= url('profile.php?id=' . rawurlencode((string)$_SESSION['id'])); ?>"><?= bookfind_translate('Profile'); ?></a>
        <a class="navbar__link <?php if ($currentPage == 'settings.php') {
                                  echo 'is-active';
                                } ?>" href="<?= url('settings.php?id=' . rawurlencode((string)$_SESSION['id'])); ?>"><?= bookfind_translate('Settings'); ?></a>
        <a class="navbar__link <?php if ($currentPage == 'loans.php') {
                                  echo 'is-active';
                                } ?>" href="<?= url('loans.php?id=' . rawurlencode((string)$_SESSION['id'])); ?>"><?= bookfind_translate('Loans'); ?></a>
      <?php }
      if (isset($_SESSION['auth']) && $_SESSION['grade'] != 0) { ?>
        <a class="navbar__link" href="<?= url('gestion/index.php'); ?>"><?= bookfind_translate('Management'); ?></a>
      <?php } ?>
    </div>
  </div>
</nav>