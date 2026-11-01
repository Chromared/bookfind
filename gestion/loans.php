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
require 'actions/books/showAllLoans.php';
require '../actions/functions/conversionDateHour.php';
require '../actions/functions/conversionDate.php';
require '../actions/functions/colorLoanDateFunction.php'; ?>
<!DOCTYPE html>
<html lang="en" data-theme="<?php include '../actions/users/decodeThemeAction.php'; ?>">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BookFind — Loans</title>
  <?php include '../includes/header.php'; ?>
</head>

<body class="admin">
  <?php include 'includes/navbar.php'; ?>

  <?php $nbOverdue = $selectLoans1->rowCount();
  $nbDueToday = $selectLoans2->rowCount();
  $nbOngoing = $selectLoans3->rowCount();
  $nbReturned = $selectLoans4->rowCount(); ?>

  <main class="page">
    <div class="container">
      <div class="narrow">
        <div class="page-head">
          <div>
            <h1 class="page-head__title">Loans</h1>
            <p class="page-head__sub">All library loans and their due dates.</p>
          </div>
        </div>
        <div class="tabs-block">
          <div class="tabs" role="tablist">
            <button class="tabs__item <?php if ($nbOverdue > 0) { echo 'is-active'; } ?>" id="retard-tab" data-tab="retard" role="tab" aria-selected="<?php echo $nbOverdue > 0 ? 'true' : 'false'; ?>" <?php if ($nbOverdue == 0) { echo 'disabled'; } ?>>Overdue <span class="tabs__count"><?= $nbOverdue ?></span></button>
            <button class="tabs__item <?php if ($nbOverdue == 0 and $nbDueToday > 0) { echo 'is-active'; } ?>" id="aujourdhui-tab" data-tab="aujourdhui" role="tab" aria-selected="<?php echo ($nbOverdue == 0 and $nbDueToday > 0) ? 'true' : 'false'; ?>" <?php if ($nbDueToday == 0) { echo 'disabled'; } ?>>Due today <span class="tabs__count"><?= $nbDueToday ?></span></button>
            <button class="tabs__item <?php if ($nbOverdue == 0 and $nbDueToday == 0 and $nbOngoing > 0) { echo 'is-active'; } ?>" id="encours-tab" data-tab="encours" role="tab" aria-selected="<?php echo ($nbOverdue == 0 and $nbDueToday == 0 and $nbOngoing > 0) ? 'true' : 'false'; ?>" <?php if ($nbOngoing == 0) { echo 'disabled'; } ?>>Ongoing <span class="tabs__count"><?= $nbOngoing ?></span></button>
            <button class="tabs__item <?php if ($nbOverdue == 0 and $nbDueToday == 0 and $nbOngoing == 0 and $nbReturned > 0) { echo 'is-active'; } ?>" id="returned-tab" data-tab="returned" role="tab" aria-selected="<?php echo ($nbOverdue == 0 and $nbDueToday == 0 and $nbOngoing == 0 and $nbReturned > 0) ? 'true' : 'false'; ?>" <?php if ($nbReturned == 0) { echo 'disabled'; } ?>>Returned <span class="tabs__count"><?= $nbReturned ?></span></button>
          </div>

          <div class="tab-pane <?php if ($nbOverdue > 0) { echo 'is-active'; } ?>" id="retard" role="tabpanel">
            <div class="stack">
              <?php if ($selectLoans1->rowCount() > 0) {
                while ($loanInfos1 = $selectLoans1->fetch()) {
                  $selectBookLoans1 = $db->prepare('SELECT * FROM books WHERE id = ?');
                  $selectBookLoans1->execute(array($loanInfos1['book_id']));
                  $fetchedBooks = $selectBookLoans1->fetch(); ?>
                  <div class="card">
                    <div class="card__body">
                      <h2 class="card__title"><?= htmlspecialchars($fetchedBooks['title']); ?></h2>
                      <p class="card__subtitle"><?= htmlspecialchars($fetchedBooks['author']); ?></p>
                      <div class="mt-3">
                        <div class="kv">
                          <span class="kv__k">Borrowed by</span>
                          <span class="kv__v"><a href="../profile.php?id=<?= htmlspecialchars($loanInfos1['borrower_id']); ?>"><?= htmlspecialchars($loanInfos1['borrower_name']); ?></a></span>
                        </div>
                        <div class="kv">
                          <span class="kv__k">Borrowed on</span>
                          <span class="kv__v"><?php ConversionDateHour($loanInfos1['loan_date']); ?></span>
                        </div>
                        <div class="kv">
                          <span class="kv__k">Due on</span>
                          <span class="kv__v"><?php ColorLoanDate($loanInfos1['due_date']); ?></span>
                        </div>
                      </div>
                      <div class="btn-group mt-4">
                        <a href="books-reader.php?id=<?= htmlspecialchars($fetchedBooks['id']); ?>" class="btn btn--secondary">View</a>
                        <a href="loan.php?id=<?= htmlspecialchars($fetchedBooks['id']); ?><?php if ($fetchedBooks['status'] == 1) { echo '&user_id=' . htmlspecialchars($loanInfos1['borrower_id']); } ?>" class="btn btn--success">Loan</a>
                      </div>
                    </div>
                  </div>
              <?php }
              } ?>
            </div>
          </div>

          <div class="tab-pane <?php if ($nbOverdue == 0 and $nbDueToday > 0) { echo 'is-active'; } ?>" id="aujourdhui" role="tabpanel">
            <div class="stack">
              <?php if ($selectLoans2->rowCount() > 0) {
                while ($loanInfos2 = $selectLoans2->fetch()) {
                  $selectBookLoans2 = $db->prepare('SELECT * FROM books WHERE id = ?');
                  $selectBookLoans2->execute(array($loanInfos2['book_id']));
                  $fetchedBooks = $selectBookLoans2->fetch(); ?>
                  <div class="card">
                    <div class="card__body">
                      <h2 class="card__title"><?= htmlspecialchars($fetchedBooks['title']); ?></h2>
                      <p class="card__subtitle"><?= htmlspecialchars($fetchedBooks['author']); ?></p>
                      <div class="mt-3">
                        <div class="kv">
                          <span class="kv__k">Borrowed by</span>
                          <span class="kv__v"><a href="../profile.php?id=<?= htmlspecialchars($loanInfos2['borrower_id']); ?>"><?= htmlspecialchars($loanInfos2['borrower_name']); ?></a></span>
                        </div>
                        <div class="kv">
                          <span class="kv__k">Borrowed on</span>
                          <span class="kv__v"><?php ConversionDateHour($loanInfos2['loan_date']); ?></span>
                        </div>
                        <div class="kv">
                          <span class="kv__k">Due on</span>
                          <span class="kv__v"><?php ColorLoanDate($loanInfos2['due_date']); ?></span>
                        </div>
                      </div>
                      <div class="btn-group mt-4">
                        <a href="books-reader.php?id=<?= htmlspecialchars($fetchedBooks['id']); ?>" class="btn btn--secondary">View</a>
                        <a href="loan.php?id=<?= htmlspecialchars($fetchedBooks['id']); ?><?php if ($fetchedBooks['status'] == 1) { echo '&user_id=' . htmlspecialchars($loanInfos2['borrower_id']); } ?>" class="btn btn--success">Loan</a>
                      </div>
                    </div>
                  </div>
              <?php }
              } ?>
            </div>
          </div>

          <div class="tab-pane <?php if ($nbOverdue == 0 and $nbDueToday == 0 and $nbOngoing > 0) { echo 'is-active'; } ?>" id="encours" role="tabpanel">
            <div class="stack">
              <?php if ($selectLoans3->rowCount() > 0) {
                while ($loanInfos3 = $selectLoans3->fetch()) {
                  $selectBookLoans3 = $db->prepare('SELECT * FROM books WHERE id = ?');
                  $selectBookLoans3->execute(array($loanInfos3['book_id']));
                  $fetchedBooks = $selectBookLoans3->fetch(); ?>
                  <div class="card">
                    <div class="card__body">
                      <h2 class="card__title"><?= htmlspecialchars($fetchedBooks['title']); ?></h2>
                      <p class="card__subtitle"><?= htmlspecialchars($fetchedBooks['author']); ?></p>
                      <div class="mt-3">
                        <div class="kv">
                          <span class="kv__k">Borrowed by</span>
                          <span class="kv__v"><a href="../profile.php?id=<?= htmlspecialchars($loanInfos3['borrower_id']); ?>"><?= htmlspecialchars($loanInfos3['borrower_name']); ?></a></span>
                        </div>
                        <div class="kv">
                          <span class="kv__k">Borrowed on</span>
                          <span class="kv__v"><?php ConversionDateHour($loanInfos3['loan_date']); ?></span>
                        </div>
                        <div class="kv">
                          <span class="kv__k">Due on</span>
                          <span class="kv__v"><?php ColorLoanDate($loanInfos3['due_date']); ?></span>
                        </div>
                      </div>
                      <div class="btn-group mt-4">
                        <a href="books-reader.php?id=<?= htmlspecialchars($fetchedBooks['id']); ?>" class="btn btn--secondary">View</a>
                        <a href="loan.php?id=<?= htmlspecialchars($fetchedBooks['id']); ?><?php if ($fetchedBooks['status'] == 1) { echo '&user_id=' . htmlspecialchars($loanInfos3['borrower_id']); } ?>" class="btn btn--success">Loan</a>
                      </div>
                    </div>
                  </div>
              <?php }
              } ?>
            </div>
          </div>

          <div class="tab-pane <?php if ($nbOverdue == 0 and $nbDueToday == 0 and $nbOngoing == 0 and $nbReturned > 0) { echo 'is-active'; } ?>" id="returned" role="tabpanel">
            <div class="stack">
              <?php if ($selectLoans4->rowCount() > 0) {
                while ($loanInfos4 = $selectLoans4->fetch()) {
                  $selectBookLoans4 = $db->prepare('SELECT * FROM books WHERE id = ?');
                  $selectBookLoans4->execute(array($loanInfos4['book_id']));
                  $fetchedBooks = $selectBookLoans4->fetch(); ?>
                  <div class="card">
                    <div class="card__body">
                      <h2 class="card__title"><?= htmlspecialchars($fetchedBooks['title']); ?></h2>
                      <p class="card__subtitle"><?= htmlspecialchars($fetchedBooks['author']); ?></p>
                      <div class="mt-3">
                        <div class="kv">
                          <span class="kv__k">Borrowed by</span>
                          <span class="kv__v"><a href="../profile.php?id=<?= htmlspecialchars($loanInfos4['borrower_id']); ?>"><?= htmlspecialchars($loanInfos4['borrower_name']); ?></a></span>
                        </div>
                        <div class="kv">
                          <span class="kv__k">Borrowed on</span>
                          <span class="kv__v"><?php ConversionDateHour($loanInfos4['loan_date']); ?></span>
                        </div>
                        <div class="kv">
                          <span class="kv__k">Returned on</span>
                          <span class="kv__v"><?php ConversionDateHour($loanInfos4['return_date']); ?></span>
                        </div>
                      </div>
                      <div class="btn-group mt-4">
                        <a href="books-reader.php?id=<?= htmlspecialchars($fetchedBooks['id']); ?>" class="btn btn--secondary">View</a>
                      </div>
                    </div>
                  </div>
              <?php }
              } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
  <?php include '../includes/footer.php'; ?>
</body>

</html>
