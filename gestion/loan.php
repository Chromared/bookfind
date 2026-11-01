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
require '../actions/functions/logFunction.php';
require 'actions/books/updateLoan.php';
if (($booksInfos['status'] ?? null) == 1) {
  require 'actions/books/showOneLoan.php';
}
require 'actions/books/addLoanAction.php';
require 'actions/books/returnLoan.php';

$dateIn30Days = date('Y-m-d', strtotime('+30 days')); ?>
<!DOCTYPE html>
<html lang="en" data-theme="<?php include '../actions/users/decodeThemeAction.php'; ?>">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BookFind — Edit a loan</title>
  <?php include '../includes/header.php'; ?>
</head>

<body class="admin">
  <?php include 'includes/navbar.php'; ?>
  <main class="page">
    <div class="container">
      <div class="narrow stack">
        <?php if ((($booksInfos['status'] ?? null) == 0) or (($booksInfos['status'] ?? null) == 2)) { ?>
          <form method="post">
            <?= csrf_field(); ?>
            <div class="card">
              <div class="card__body">
                <h1 class="card__title">Add a loan</h1>
                <?php if (isset($msg1)) { ?>
                  <div class="alert alert--warning" role="alert">
                    <svg class="icon"><use href="#i-alert"/></svg>
                    <div><?= $msg1; ?></div>
                  </div>
                <?php } ?>
                <div class="field">
                  <label for="user_id" class="label">Borrower</label>
                  <div class="select-search">
                    <input type="search" class="input" placeholder="Search for a user..." data-select-search />
                    <select id="user_id" name="user_id" class="select">
                      <option value="">--- Select a user ---</option>
                      <?php include 'actions/users/list-usersWithClass.php'; ?>
                    </select>
                  </div>
                </div>
                <div class="field">
                  <label for="date" class="label">Return date</label>
                  <input type="date" class="input" id="date" value="<?= $dateIn30Days; ?>" name="date" required />
                </div>
                <div class="field">
                  <input type="submit" name="validateAdd" value="Add the loan" class="btn btn--primary" />
                </div>
                <input type="hidden" name="book_id" value="<?= htmlspecialchars($_GET['id']); ?>" />
              </div>
            </div>
          </form>

        <?php } elseif (($booksInfos['status'] ?? null) == 1) {
          if (isset($_GET['id']) and !empty($_GET['id'])) { ?>

            <!-- Edit return date -->
            <form method="post">
              <?= csrf_field(); ?>
              <div class="card">
                <div class="card__body">
                  <h1 class="card__title">Edit the return date</h1>
                  <?php if (isset($_GET['success'])) { ?>
                    <div class="alert alert--success" role="alert">
                      <svg class="icon"><use href="#i-check"/></svg>
                      <div>Due date modified successfully!</div>
                    </div>
                  <?php } ?>
                  <div class="field">
                    <label for="updateDate" class="label">New return date</label>
                    <input type="date" class="input" id="updateDate" name="date" value="<?= htmlspecialchars($loanInfos['due_date'] ?? '') ?>" required />
                  </div>
                  <div class="field">
                    <input type="submit" name="validateUpdate" value="Save" class="btn btn--primary" />
                  </div>
                  <input type="hidden" name="id" value="<?= $_GET['id'] ?>" />
                  <input type="hidden" name="user_id" value="<?= $_GET['user_id'] ?>" />
                </div>
              </div>
            </form>

            <!-- Return the loan -->
            <form method="post">
              <?= csrf_field(); ?>
              <div class="card">
                <div class="card__body">
                  <h1 class="card__title">Return the loan</h1>
                  <div class="field">
                    <input type="submit" name="validateReturn" value="Return the loan" class="btn btn--success" />
                  </div>
                  <input type="hidden" name="id" value="<?= $_GET['id'] ?>" />
                  <input type="hidden" name="user_id" value="<?= $_GET['user_id'] ?>" />
                </div>
              </div>
            </form>

          <?php } else {
            echo 'Missing user ID.';
          }
        } ?>
      </div>
    </div>
  </main>
  <?php include '../includes/footer.php'; ?>
</body>

</html>
