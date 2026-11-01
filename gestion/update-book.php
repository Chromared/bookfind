<?php
//This file belongs to the BookFind project.
//
//BookFind is distributed under the terms of the GNU Affero General Public License v3.0.
//
//Copyright (C) 2025 Chromared
?>

<?php require '../actions/database.php';
require '../actions/users/securityAction.php';
require 'actions/users/securityAdminAction.php';
require '../actions/functions/logFunction.php';
require 'actions/books/updateBooksAction.php';
require '../actions/books/showOneBookAction.php'; ?>
<!DOCTYPE html>
<html lang="en" data-theme="<?php include '../actions/users/decodeThemeAction.php'; ?>">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BookFind — Update a book</title>
  <?php include '../includes/header.php'; ?>
</head>

<body class="admin">
  <?php include 'includes/navbar.php'; ?>
  <main class="page">
    <div class="container">
      <div class="narrow">
        <form method="POST" autocomplete="off">
          <?= csrf_field(); ?>
          <div class="card">
            <div class="card__body">
              <div class="alert alert--info" role="alert">
                <svg class="icon"><use href="#i-info"/></svg>
                <div>Fields marked with * are required.</div>
              </div>
              <?php if (isset($errorMsg)) { ?>
                <div class="alert alert--warning" role="alert">
                  <svg class="icon"><use href="#i-alert"/></svg>
                  <div><?= $errorMsg; ?></div>
                </div>
              <?php } elseif (isset($successMsg)) { ?>
                <div class="alert alert--success" role="alert">
                  <svg class="icon"><use href="#i-check"/></svg>
                  <div>Book saved successfully</div>
                </div>
              <?php } ?>
              <div class="field">
                <label for="isbn" class="label">ISBN*</label>
                <input type="number" name="isbn" id="isbn" class="input" value="<?= htmlspecialchars($booksInfos['isbn'] ?? ''); ?>" min="1000000000" max="9999999999999" autofocus required />
              </div>
              <div class="field">
                <label for="title" class="label">Title*</label>
                <input type="text" name="title" id="title" class="input" value="<?= htmlspecialchars($booksInfos['title'] ?? ''); ?>" required />
              </div>
              <div class="field">
                <label for="author" class="label">Author*</label>
                <input type="text" name="author" id="author" class="input" value="<?= htmlspecialchars($booksInfos['author'] ?? ''); ?>" required />
              </div>
              <div class="field">
                <label for="type" class="label">Type*</label>
                <input type="text" name="type" id="type" class="input" value="<?= htmlspecialchars($booksInfos['type'] ?? ''); ?>" required />
              </div>
              <div class="field">
                <label for="publisher" class="label">Publisher*</label>
                <input type="text" name="publisher" id="publisher" class="input" value="<?= htmlspecialchars($booksInfos['publisher'] ?? ''); ?>" required />
              </div>
              <div class="field">
                <label for="summary" class="label">Summary</label>
                <textarea name="summary" id="summary" class="textarea" rows="1"><?= htmlspecialchars($booksInfos['summary'] ?? ''); ?></textarea>
              </div>
              <div class="field">
                <label for="unique_id" class="label">Unique identifier</label>
                <input type="text" name="unique_id" id="unique_id" class="input" value="<?= htmlspecialchars($booksInfos['unique_id'] ?? ''); ?>" />
              </div>
              <div class="field">
                <label for="genre" class="label">Genre</label>
                <input type="text" name="genre" id="genre" class="input" value="<?= htmlspecialchars($booksInfos['genre'] ?? ''); ?>" />
              </div>
              <div class="field">
                <label for="series" class="label">Series</label>
                <input type="text" name="series" id="series" class="input" value="<?= htmlspecialchars($booksInfos['series'] ?? ''); ?>" />
              </div>
              <div class="field">
                <label for="volume" class="label">Volume no.</label>
                <input type="number" name="volume" id="volume" class="input" value="<?php if (!empty($booksInfos['series'] ?? '')) {
                                                                                    echo htmlspecialchars($booksInfos['volume'] ?? '');
                                                                                  } ?>" />
              </div>
              <div class="field">
                <input type="submit" name="validate" class="btn btn--primary" value="Save" />
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </main>
  <?php include '../includes/footer.php'; ?>
</body>

</html>
