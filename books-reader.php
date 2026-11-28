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
<?php require_once __DIR__ . '/includes/paths.php';
require_once ROOT_PATH . '/actions/functions/sessionInit.php'; ?>

<?php require_once ROOT_PATH . '/actions/functions/sessionInit.php';
require ROOT_PATH . '/actions/database.php';
require ROOT_PATH . '/actions/books/showOneBookAction.php';
require ROOT_PATH . '/actions/books/showOneLoan.php';
require ROOT_PATH . '/actions/functions/conversionDate.php';
require ROOT_PATH . '/actions/functions/conversionDateHour.php';
require ROOT_PATH . '/actions/functions/colorLoanDateFunction.php'; ?>
<!DOCTYPE html>
<html lang="<?= $GLOBALS['bookfindLocale'] === 'fr_FR' ? 'fr' : 'en'; ?>" data-theme="<?php include ROOT_PATH . '/actions/users/decodeThemeAction.php'; ?>">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= bookfind_translate('BookFind — Book information'); ?></title>
  <?php include ROOT_PATH . '/includes/header.php'; ?>
</head>

<body>
  <?php include ROOT_PATH . '/includes/navbar.php'; ?>
  <main class="page">
    <div class="container">
      <div class="page-head">
        <div>
          <h1 class="page-head__title"><?= htmlspecialchars($booksInfos['title']); ?></h1>
          <p class="page-head__sub"><?= htmlspecialchars($booksInfos['author']); ?></p>
        </div>
        <?php if (isset($_SESSION['auth']) and $_SESSION['grade'] != 0) { ?>
          <div class="page-head__actions">
            <a href="<?= url('gestion/update-book.php?id=' . rawurlencode((string)$booksInfos['id'])); ?>" class="btn btn--primary"><?= bookfind_translate('Edit'); ?></a>
            <a href="<?= url('gestion/loan.php?id=' . rawurlencode((string)$booksInfos['id']) . ($booksInfos['status'] == 1 ? '&user_id=' . rawurlencode((string)$loan['borrower_id']) : '')); ?>" class="btn btn--success"><?= bookfind_translate('Loan'); ?></a>
          </div>
        <?php } ?>
      </div>

      <div class="split">
        <div class="card">
          <div class="card__header">
            <svg class="icon"><use href="#i-book"/></svg>
            <?= bookfind_translate('About the book'); ?>
          </div>
          <div class="card__body">
            <?php if (!empty($booksInfos['summary'])) { ?>
              <p class="card__text"><?= htmlspecialchars($booksInfos['summary']); ?></p>
            <?php } else { ?>
              <p class="text-subtle"><?= bookfind_translate('No summary available.'); ?></p>
            <?php } ?>
            <div class="mt-4">
              <div class="kv">
                <span class="kv__k">ID</span>
                <span class="kv__v"><?= bookfind_translate('no.'); ?> <?= htmlspecialchars($booksInfos['id']); ?></span>
              </div>
              <div class="kv">
                <span class="kv__k">ISBN</span>
                <span class="kv__v mono"><?= htmlspecialchars($booksInfos['isbn']); ?></span>
              </div>
              <div class="kv">
                <span class="kv__k"><?= bookfind_translate('Publisher'); ?></span>
                <span class="kv__v"><?= htmlspecialchars($booksInfos['publisher']); ?></span>
              </div>
              <div class="kv">
                <span class="kv__k"><?= bookfind_translate('Type'); ?></span>
                <span class="kv__v"><?= htmlspecialchars($booksInfos['type']); ?></span>
              </div>
              <?php if (!empty($booksInfos['genre'])) { ?>
                <div class="kv">
                  <span class="kv__k"><?= bookfind_translate('Genre'); ?></span>
                  <span class="kv__v"><?= htmlspecialchars($booksInfos['genre']); ?></span>
                </div>
              <?php } ?>
              <?php if (!empty($booksInfos['unique_id'])) { ?>
                <div class="kv">
                  <span class="kv__k"><?= bookfind_translate('Unique identifier'); ?></span>
                  <span class="kv__v mono"><?php echo htmlspecialchars($booksInfos['unique_id']); ?></span>
                </div>
              <?php } ?>
              <?php if (!empty($booksInfos['series'])) { ?>
                <div class="kv">
                  <span class="kv__k"><?= bookfind_translate('Series'); ?></span>
                  <span class="kv__v"><?= bookfind_translate('Volume'); ?> <?= htmlspecialchars($booksInfos['volume']); ?> — <?= htmlspecialchars($booksInfos['series']); ?></span>
                </div>
              <?php } ?>
            </div>
          </div>
        </div>

        <div class="card">
          <div class="card__header">
            <svg class="icon"><use href="#i-arrow-up"/></svg>
            <?= bookfind_translate('Availability'); ?>
          </div>
          <div class="card__body">
            <?php if ($booksInfos['status'] == 1) { ?>
              <span class="badge badge--warning mb-3"><?= bookfind_translate('Currently on loan'); ?></span>
              <div class="mt-2">
                <div class="kv">
                  <span class="kv__k"><?= bookfind_translate('Borrowed by'); ?></span>
                  <span class="kv__v"><?php require_once ROOT_PATH . '/actions/functions/loanBorrowerFunction.php'; echo loanBorrowerHtml($loan); ?></span>
                </div>
                <div class="kv">
                  <span class="kv__k"><?= bookfind_translate('Due on'); ?></span>
                  <span class="kv__v"><?php ColorLoanDate($loan['due_date']); ?></span>
                </div>
              </div>
            <?php } else { ?>
              <span class="badge badge--success"><?= bookfind_translate('Available'); ?></span>
              <p class="text-subtle mt-3"><?= bookfind_translate('This book is available for loan.'); ?></p>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </main>
  <?php include ROOT_PATH . '/includes/footer.php'; ?>
</body>

</html>
