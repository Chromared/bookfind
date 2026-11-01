<?php
//This file belongs to the BookFind project.
//
//BookFind is distributed under the terms of the GNU Affero General Public License v3.0.
//
//Copyright (C) 2025 Chromared
?>

<?php require '../actions/database.php';
require '../actions/users/securityAction.php';
require 'actions/users/securityAdminAction.php'; ?>
<!DOCTYPE html>
<html lang="en" data-theme="<?php include '../actions/users/decodeThemeAction.php'; ?>">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BookFind — Search users</title>
  <?php include '../includes/header.php'; ?>
</head>

<body class="admin">
  <?php include 'includes/navbar.php'; ?>
  <main class="page">
    <div class="container container--wide">
      <div class="page-head">
        <div>
          <h1 class="page-head__title">Users</h1>
          <p class="page-head__sub">Search and manage library accounts.</p>
        </div>
      </div>

      <div class="searchband">
        <form method="GET">
          <div class="input-group">
            <input type="text" name="s" class="input" value="<?php if (isset($_GET['s']) and !empty($_GET['s'])) {
                                                                echo htmlspecialchars($_GET['s']);
                                                              } ?>" placeholder="First name, last name, username, class…" <?php if (!isset($_GET['s']) or empty($_GET['s'])) {
                                                                                                                                                                                                  echo 'autofocus';
                                                                                                                                                                                                } ?> />
            <button class="btn btn--outline" type="submit">
              <svg class="icon"><use href="#i-search"/></svg>
              Search
            </button>
          </div>
        </form>
      </div>

      <?php include 'actions/users/sUsers.php'; ?>
    </div>
  </main>
  <?php include '../includes/footer.php'; ?>
</body>

</html>
