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
<html lang="en" data-theme="<?php include '../actions/users/decodeThemeAction.php'; ?>">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BookFind — Page not found</title>
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
        <h1 class="error__title">Page not found</h1>
        <p class="error__text">The page you are looking for does not exist or may have been moved.</p>
        <div class="btn-group">
          <a href="/index.php" class="btn btn--primary btn--lg">Back to home</a>
          <a href="/books.php" class="btn btn--secondary btn--lg">Browse the catalog</a>
        </div>
        <form method="GET" action="/books.php" class="error__search">
          <div class="input-group">
            <input type="text" name="s" class="input" placeholder="Search for a book…" aria-label="Search for a book"/>
            <button class="btn btn--outline" type="submit">
              <svg class="icon"><use href="#i-search"/></svg>
              Search
            </button>
          </div>
        </form>
      </section>
    </div>
  </main>
  <?php include '../includes/footer.php'; ?>
</body>

</html>
