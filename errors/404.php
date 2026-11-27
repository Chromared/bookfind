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

<?php if (session_status() === PHP_SESSION_NONE) {
  require '../actions/functions/sessionInit.php';
} ?>
<!DOCTYPE html>
<html lang="<?= $GLOBALS['bookfindLocale'] === 'fr_FR' ? 'fr' : 'en'; ?>" data-theme="<?php include '../actions/users/decodeThemeAction.php'; ?>">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= bookfind_translate('BookFind — Page not found'); ?></title>
  <?php include '../includes/header.php'; ?>
</head>

<body>
  <main class="page">
    <div class="container">
      <section class="error">
        <div class="error__code" aria-hidden="true">404</div>
        <div class="error__icon">
          <svg class="icon"><use href="#i-alert"/></svg>
        </div>
        <h1 class="error__title"><?= bookfind_translate('Page not found'); ?></h1>
        <p class="error__text"><?= bookfind_translate('The page you are looking for does not exist or may have been moved.'); ?></p>
        <div class="btn-group">
          <a href="/index.php" class="btn btn--primary btn--lg"><?= bookfind_translate('Back to home'); ?></a>
          <a href="/books.php" class="btn btn--secondary btn--lg"><?= bookfind_translate('Browse the catalog'); ?></a>
        </div>
        <form method="GET" action="/books.php" class="error__search">
          <div class="input-group">
            <input type="text" name="s" class="input" placeholder="<?= bookfind_translate('Search for a book…'); ?>" aria-label="<?= bookfind_translate('Search for a book'); ?>"/>
            <button class="btn btn--outline" type="submit">
              <svg class="icon"><use href="#i-search"/></svg>
              <?= bookfind_translate('Search'); ?>
            </button>
          </div>
        </form>
      </section>
    </div>
  </main>
  <?php include '../includes/footer.php'; ?>
</body>

</html>
