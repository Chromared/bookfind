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

<?php require 'actions/functions/sessionInit.php';
require 'actions/database.php';
require 'actions/functions/conversionDate.php';
require 'actions/functions/conversionDateHour.php';
require 'actions/functions/colorLoanDateFunction.php'; ?>
<!DOCTYPE html>
<html lang="<?= $GLOBALS['bookfindLocale'] === 'fr_FR' ? 'fr' : 'en'; ?>" data-theme="<?php include 'actions/users/decodeThemeAction.php'; ?>">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= bookfind_translate('BookFind — Search for a book'); ?></title>
  <?php include 'includes/header.php'; ?>
</head>

<body>
  <?php include 'includes/navbar.php'; ?>
  <main class="page">
    <div class="container container--wide">
      <div class="page-head">
        <div>
          <h1 class="page-head__title"><?= bookfind_translate('Search for a book'); ?></h1>
          <p class="page-head__sub"><?= bookfind_translate('Browse the C.D.I. catalog.'); ?></p>
        </div>
      </div>

      <div class="searchband">
        <form method="GET">
          <div class="input-group">
            <input type="text" name="s" class="input" value="<?php if (isset($_GET['s']) and !empty($_GET['s'])) {
                                                                echo htmlspecialchars($_GET['s']);
                                                              } ?>" placeholder="<?= bookfind_translate('Title, author, ISBN, publisher, genre…'); ?>" <?php if (!isset($_GET['s']) or empty($_GET['s'])) {
                                                                                                                                                                                                      echo 'autofocus';
                                                                                                                                                                                                    } ?> />
            <button class="btn btn--outline" type="submit">
              <svg class="icon"><use href="#i-search"/></svg>
              <?= bookfind_translate('Search'); ?>
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
