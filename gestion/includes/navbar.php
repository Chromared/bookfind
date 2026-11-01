<?php
//This file belongs to the BookFind project.
//
//BookFind is distributed under the terms of the GNU Affero General Public License v3.0.
//
//Copyright (C) 2025 Chromared
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

  <nav class="sidebar__nav" aria-label="Navigation">
    <a class="sidebar__link <?php if ($currentPage == 'index.php') { echo 'is-active'; } ?>" href="index.php">
      <svg class="icon"><use href="#i-grid"/></svg>Overview
    </a>

    <div class="sidebar__label">Books</div>
    <a class="sidebar__link <?php if ($currentPage == 'books.php') { echo 'is-active'; } ?>" href="books.php">
      <svg class="icon"><use href="#i-search"/></svg>Search
    </a>
    <a class="sidebar__link <?php if ($currentPage == 'add-book.php') { echo 'is-active'; } ?>" href="add-book.php">
      <svg class="icon"><use href="#i-save"/></svg>Add
    </a>
    <a class="sidebar__link <?php if ($currentPage == 'loans.php') { echo 'is-active'; } ?>" href="loans.php">
      <svg class="icon"><use href="#i-arrow-up"/></svg>Loans
    </a>

    <div class="sidebar__label">Users</div>
    <a class="sidebar__link <?php if ($currentPage == 'users.php') { echo 'is-active'; } ?>" href="users.php">
      <svg class="icon"><use href="#i-people"/></svg>Users
    </a>

    <?php if ($_SESSION['grade'] == 1) { ?>
      <div class="sidebar__label">Administration</div>
      <a class="sidebar__link <?php if ($currentPage == 'bookfind.php' && $tab == 'database') { echo 'is-active'; } ?>" href="bookfind.php?tab=database">
        <svg class="icon"><use href="#i-db"/></svg>Database
      </a>
      <a class="sidebar__link <?php if ($currentPage == 'bookfind.php' && $tab == 'classes') { echo 'is-active'; } ?>" href="bookfind.php?tab=classes">
        <svg class="icon"><use href="#i-tag"/></svg>Classes
      </a>
      <a class="sidebar__link <?php if ($currentPage == 'bookfind.php' && $tab == 'users') { echo 'is-active'; } ?>" href="bookfind.php?tab=users">
        <svg class="icon"><use href="#i-upload"/></svg><?php echo _('Import users and regenerate usernames'); ?>
      </a>
      <a class="sidebar__link <?php if ($currentPage == 'logs.php') { echo 'is-active'; } ?>" href="logs.php">
        <svg class="icon"><use href="#i-doc"/></svg>Logs
      </a>
      <a class="sidebar__link <?php if ($currentPage == 'config-ht.php') { echo 'is-active'; } ?>" href="config-ht.php">
        <svg class="icon"><use href="#i-key"/></svg>.htaccess
      </a>
    <?php } ?>
  </nav>

  <div class="sidebar__foot">
    <a class="sidebar__link" href="../settings.php?id=<?= htmlspecialchars($_SESSION['id']); ?>">
      <svg class="icon"><use href="#i-settings"/></svg>Settings
    </a>
    <a class="sidebar__link" href="../index.php">
      <svg class="icon"><use href="#i-arrow-down"/></svg>Exit management
    </a>
  </div>
</aside>

<div class="sidebar__backdrop" data-sidebar-close></div>

<header class="topbar">
  <button class="topbar__toggle" type="button" data-nav-toggle="sidebar" aria-controls="sidebar" aria-expanded="false" aria-label="Open menu">
    <svg class="icon"><use href="#i-menu"/></svg>
  </button>
  <span class="topbar__title"><?= htmlspecialchars(_($topbarTitle), ENT_QUOTES, 'UTF-8'); ?></span>
  <div class="topbar__right">
    <span class="topbar__user">
      <svg class="icon"><use href="#i-people"/></svg>
      <?= htmlspecialchars($_SESSION['firstname'] ?? $_SESSION['username'] ?? ''); ?>
    </span>
    <a class="btn btn--ghost" href="../index.php">
      <svg class="icon"><use href="#i-arrow-down"/></svg>Site
    </a>
  </div>
</header>
