<?php
//This file belongs to the BookFind project.
//
//BookFind is distributed under the terms of the GNU Affero General Public License v3.0.
//
//Copyright (C) 2025 Chromared
?>

<?php if (session_status() === PHP_SESSION_NONE) {
  require '../actions/functions/sessionInit.php';
} ?>
<!DOCTYPE html>
<html lang="<?= $GLOBALS['bookfindLocale'] === 'fr_FR' ? 'fr' : 'en'; ?>" data-theme="<?php include '../actions/users/decodeThemeAction.php'; ?>">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= bookfind_translate('BookFind — Access denied'); ?></title>
  <?php include '../includes/header.php'; ?>
</head>

<body>
  <main class="page">
    <div class="container">
      <section class="error">
        <div class="error__code" aria-hidden="true">403</div>
        <div class="error__icon">
          <svg class="icon"><use href="#i-alert"/></svg>
        </div>
        <h1 class="error__title"><?= bookfind_translate('Access denied'); ?></h1>
        <p class="error__text"><?= bookfind_translate('You do not have the required permissions to access this page.'); ?></p>
        <div class="btn-group">
          <a href="/index.php" class="btn btn--primary btn--lg"><?= bookfind_translate('Back to home'); ?></a>
          <?php if (!isset($_SESSION['auth'])) { ?>
            <a href="/login.php" class="btn btn--secondary btn--lg"><?= bookfind_translate('Sign in'); ?></a>
          <?php } else { ?>
            <a href="/gestion/index.php" class="btn btn--secondary btn--lg"><?= bookfind_translate('Management'); ?></a>
          <?php } ?>
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
