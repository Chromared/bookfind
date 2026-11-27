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

<?php
$currentPage = basename($_SERVER['SCRIPT_NAME']);
$tab = $_GET['tab'] ?? '';

$titles = [
    'index.php' => 'Overview',
    'books.php' => 'Search for a book',
    'add-book.php' => 'Add a book',
    'update-book.php' => 'Edit a book',
    'loans.php' => 'Loans',
    'user-loans.php' => 'A user\'s loans',
    'loan.php' => 'Manage a loan',
    'books-reader.php' => 'Book details',
    'users.php' => 'Users',
    'update-user.php' => 'Edit a user',
    'bookfind.php' => 'Manage BookFind',
    'logs.php' => 'Logs',
    'config-ht.php' => '.htaccess tools',
];
$topbarTitle = $titles[$currentPage] ?? 'Management';
?>

<aside class="sidebar" id="sidebar">
  <div class="sidebar__head">
    <a class="navbar__brand" href="index.php">
      <img src="../assets/logo.svg" alt="BookFind" class="navbar__logo">
      <span>BookFind</span>
    </a>
  </div>

  <nav class="sidebar__nav" aria-label="<?= bookfind_translate('Navigation'); ?>">
    <a class="sidebar__link <?php if ($currentPage == 'index.php') { echo 'is-active'; } ?>" href="index.php">
      <svg class="icon"><use href="#i-grid"/></svg><?= bookfind_translate('Overview'); ?>
    </a>

    <div class="sidebar__label"><?= bookfind_translate('Books'); ?></div>
    <a class="sidebar__link <?php if ($currentPage == 'books.php') { echo 'is-active'; } ?>" href="books.php">
      <svg class="icon"><use href="#i-search"/></svg><?= bookfind_translate('Search'); ?>
    </a>
    <a class="sidebar__link <?php if ($currentPage == 'add-book.php') { echo 'is-active'; } ?>" href="add-book.php">
      <svg class="icon"><use href="#i-save"/></svg><?= bookfind_translate('Add'); ?>
    </a>
    <a class="sidebar__link <?php if ($currentPage == 'loans.php') { echo 'is-active'; } ?>" href="loans.php">
      <svg class="icon"><use href="#i-arrow-up"/></svg><?= bookfind_translate('Loans'); ?>
    </a>

    <div class="sidebar__label"><?= bookfind_translate('Users'); ?></div>
    <a class="sidebar__link <?php if ($currentPage == 'users.php') { echo 'is-active'; } ?>" href="users.php">
      <svg class="icon"><use href="#i-people"/></svg><?= bookfind_translate('Users'); ?>
    </a>

    <?php if ($_SESSION['grade'] == 1) { ?>
      <div class="sidebar__label"><?= bookfind_translate('Administration'); ?></div>
      <a class="sidebar__link <?php if ($currentPage == 'bookfind.php' && $tab == 'database') { echo 'is-active'; } ?>" href="bookfind.php?tab=database">
        <svg class="icon"><use href="#i-db"/></svg><?= bookfind_translate('Database'); ?>
      </a>
      <a class="sidebar__link <?php if ($currentPage == 'bookfind.php' && $tab == 'classes') { echo 'is-active'; } ?>" href="bookfind.php?tab=classes">
        <svg class="icon"><use href="#i-tag"/></svg><?= bookfind_translate('Classes'); ?>
      </a>
      <a class="sidebar__link <?php if ($currentPage == 'bookfind.php' && $tab == 'users') { echo 'is-active'; } ?>" href="bookfind.php?tab=users">
        <svg class="icon"><use href="#i-upload"/></svg><?php echo bookfind_translate('Import users and regenerate usernames'); ?>
      </a>
      <a class="sidebar__link <?php if ($currentPage == 'logs.php') { echo 'is-active'; } ?>" href="logs.php">
        <svg class="icon"><use href="#i-doc"/></svg><?= bookfind_translate('Logs'); ?>
      </a>
      <a class="sidebar__link <?php if ($currentPage == 'config-ht.php') { echo 'is-active'; } ?>" href="config-ht.php">
        <svg class="icon"><use href="#i-key"/></svg><?= bookfind_translate('.htaccess'); ?>
      </a>
    <?php } ?>
  </nav>

  <div class="sidebar__foot">
    <a class="sidebar__link" href="../settings.php?id=<?= htmlspecialchars($_SESSION['id']); ?>">
      <svg class="icon"><use href="#i-settings"/></svg><?= bookfind_translate('Settings'); ?>
    </a>
    <a class="sidebar__link" href="../index.php">
      <svg class="icon"><use href="#i-arrow-down"/></svg><?= bookfind_translate('Exit management'); ?>
    </a>
  </div>
</aside>

<div class="sidebar__backdrop" data-sidebar-close></div>

<header class="topbar">
  <button class="topbar__toggle" type="button" data-nav-toggle="sidebar" aria-controls="sidebar" aria-expanded="false" aria-label="<?= bookfind_translate('Open menu'); ?>">
    <svg class="icon"><use href="#i-menu"/></svg>
  </button>
  <span class="topbar__title"><?= htmlspecialchars(bookfind_translate($topbarTitle), ENT_QUOTES, 'UTF-8'); ?></span>
  <div class="topbar__right">
    <span class="topbar__user">
      <svg class="icon"><use href="#i-people"/></svg>
      <?= htmlspecialchars($_SESSION['firstname'] ?? $_SESSION['username'] ?? ''); ?>
    </span>
    <a class="btn btn--ghost" href="../index.php">
      <svg class="icon"><use href="#i-arrow-down"/></svg><?= bookfind_translate('Site'); ?>
    </a>
  </div>
</header>
