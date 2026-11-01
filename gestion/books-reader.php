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
require '../actions/books/showOneBookAction.php';
require '../actions/books/showOneLoan.php';
require '../actions/functions/conversionDate.php';
require '../actions/functions/conversionDateHour.php';
require '../actions/functions/colorLoanDateFunction.php'; ?>
<!DOCTYPE html>
<html lang="en" data-theme="<?php include '../actions/users/decodeThemeAction.php'; ?>">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BookFind — Book information</title>
  <?php include '../includes/header.php'; ?>
</head>

<body class="admin">
  <?php include 'includes/navbar.php'; ?>
  <main class="page">
    <div class="container">
      <div class="page-head">
        <div>
          <h1 class="page-head__title"><?= htmlspecialchars($booksInfos['title']); ?></h1>
          <p class="page-head__sub"><?= htmlspecialchars($booksInfos['author']); ?></p>
        </div>
        <div class="page-head__actions">
          <a href="update-book.php?id=<?= htmlspecialchars($booksInfos['id']); ?>" class="btn btn--primary">Edit</a>
          <a href="loan.php?id=<?= htmlspecialchars($booksInfos['id']); ?><?php if ($booksInfos['status'] == 1) { echo '&user_id=' . htmlspecialchars($loan['borrower_id']); } ?>" class="btn btn--success">Loan</a>
        </div>
      </div>

      <div class="split">
        <div class="card">
          <div class="card__header">
            <svg class="icon"><use href="#i-book"/></svg>
            About the book
          </div>
          <div class="card__body">
            <?php if (!empty($booksInfos['summary'])) { ?>
              <p class="card__text"><?= htmlspecialchars($booksInfos['summary']); ?></p>
            <?php } else { ?>
              <p class="text-subtle">No summary available.</p>
            <?php } ?>
            <div class="mt-4">
              <div class="kv">
                <span class="kv__k">ID</span>
                <span class="kv__v">no. <?= htmlspecialchars($booksInfos['id']); ?></span>
              </div>
              <div class="kv">
                <span class="kv__k">ISBN</span>
                <span class="kv__v mono"><?= htmlspecialchars($booksInfos['isbn']); ?></span>
              </div>
              <div class="kv">
                <span class="kv__k">Publisher</span>
                <span class="kv__v"><?= htmlspecialchars($booksInfos['publisher']); ?></span>
              </div>
              <div class="kv">
                <span class="kv__k">Type</span>
                <span class="kv__v"><?= htmlspecialchars($booksInfos['type']); ?></span>
              </div>
              <?php if (!empty($booksInfos['genre'])) { ?>
                <div class="kv">
                  <span class="kv__k">Genre</span>
                  <span class="kv__v"><?= htmlspecialchars($booksInfos['genre']); ?></span>
                </div>
              <?php } ?>
              <?php if (!empty($booksInfos['unique_id'])) { ?>
                <div class="kv">
                  <span class="kv__k">Unique identifier</span>
                  <span class="kv__v mono"><?php echo htmlspecialchars($booksInfos['unique_id']); ?></span>
                </div>
              <?php } ?>
              <?php if (!empty($booksInfos['series'])) { ?>
                <div class="kv">
                  <span class="kv__k">Series</span>
                  <span class="kv__v">Volume <?= htmlspecialchars($booksInfos['volume']); ?> — <?= htmlspecialchars($booksInfos['series']); ?></span>
                </div>
              <?php } ?>
            </div>
          </div>
        </div>

        <div class="card">
          <div class="card__header">
            <svg class="icon"><use href="#i-arrow-up"/></svg>
            Availability
          </div>
          <div class="card__body">
            <?php if ($booksInfos['status'] == 1) { ?>
              <span class="badge badge--warning mb-3">Currently on loan</span>
              <div class="mt-2">
                <div class="kv">
                  <span class="kv__k">Borrowed by</span>
                  <span class="kv__v"><a href="../profile.php?id=<?= htmlspecialchars($loan['borrower_id']); ?>"><?= htmlspecialchars($loan['borrower_name']); ?></a></span>
                </div>
                <div class="kv">
                  <span class="kv__k">Due on</span>
                  <span class="kv__v"><?php ColorLoanDate($loan['due_date']); ?></span>
                </div>
              </div>
            <?php } else { ?>
              <span class="badge badge--success">Available</span>
              <p class="text-subtle mt-3">This book is available for loan.</p>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </main>
  <?php include '../includes/footer.php'; ?>
</body>

</html>
