<?php
//This file belongs to the BookFind project.
//
//BookFind is distributed under the terms of the GNU Affero General Public License v3.0.
//
//Copyright (C) 2025 Chromared
?>

<?php require 'actions/functions/sessionInit.php';
require 'actions/database.php';
require 'actions/functions/conversionDate.php';
require 'actions/functions/conversionDateHour.php';
require 'actions/functions/colorLoanDateFunction.php'; ?>
<!DOCTYPE html>
<html lang="en" data-theme="<?php include 'actions/users/decodeThemeAction.php'; ?>">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BookFind — Search for a book</title>
  <?php include 'includes/header.php'; ?>
</head>

<body>
  <?php include 'includes/navbar.php'; ?>
  <main class="page">
    <div class="container container--wide">
      <div class="page-head">
        <div>
          <h1 class="page-head__title">Search for a book</h1>
          <p class="page-head__sub">Browse the C.D.I. catalog.</p>
        </div>
      </div>

      <div class="searchband">
        <form method="GET">
          <div class="input-group">
            <input type="text" name="s" class="input" value="<?php if (isset($_GET['s']) and !empty($_GET['s'])) {
                                                                echo htmlspecialchars($_GET['s']);
                                                              } ?>" placeholder="Title, author, ISBN, publisher, genre…" <?php if (!isset($_GET['s']) or empty($_GET['s'])) {
                                                                                                                                                                                                      echo 'autofocus';
                                                                                                                                                                                                    } ?> />
            <button class="btn btn--outline" type="submit">
              <svg class="icon"><use href="#i-search"/></svg>
              Search
            </button>
          </div>
        </form>
      </div>

      <?php include 'actions/books/sBooks.php'; ?>
    </div>
  </main>
  <?php include 'includes/footer.php'; ?>
</body>

</html>
