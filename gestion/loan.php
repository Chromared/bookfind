<?php require_once dirname(__DIR__) . '/includes/paths.php'; require_once ROOT_PATH . '/actions/functions/sessionInit.php'; ?>
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

<?php require ROOT_PATH . '/actions/database.php';
require ROOT_PATH . '/actions/users/securityAction.php';
require ROOT_PATH . '/gestion/actions/users/securityAdminAction.php';
require ROOT_PATH . '/actions/books/showOneBookAction.php';
require ROOT_PATH . '/actions/functions/logFunction.php';
require ROOT_PATH . '/gestion/actions/books/updateLoan.php';
if (($booksInfos['status'] ?? null) == 1) {
  require ROOT_PATH . '/gestion/actions/books/showOneLoan.php';
}
require ROOT_PATH . '/gestion/actions/books/addLoanAction.php';
require ROOT_PATH . '/gestion/actions/books/returnLoan.php';

$dateIn30Days = date('Y-m-d', strtotime('+30 days')); ?>
<!DOCTYPE html>
<html lang="<?= $GLOBALS['bookfindLocale'] === 'fr_FR' ? 'fr' : 'en'; ?>" data-theme="<?php include ROOT_PATH . '/actions/users/decodeThemeAction.php'; ?>">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= bookfind_translate('BookFind — Edit a loan'); ?></title>
  <?php include ROOT_PATH . '/includes/header.php'; ?>
</head>

<body class="admin">
  <?php include ROOT_PATH . '/gestion/includes/navbar.php'; ?>
  <main class="page">
    <div class="container">
      <div class="narrow stack">
        <?php if ((($booksInfos['status'] ?? null) == 0) or (($booksInfos['status'] ?? null) == 2)) { ?>
          <form action="<?= url(ltrim(str_replace(BASE_URL, '', $_SERVER['SCRIPT_NAME']), '/')) . (!empty($_SERVER['QUERY_STRING']) ? '?' . htmlspecialchars($_SERVER['QUERY_STRING'], ENT_QUOTES, 'UTF-8') : ''); ?>" method="post">
            <?= csrf_field(); ?>
            <div class="card">
              <div class="card__body">
                <h1 class="card__title"><?= bookfind_translate('Add a loan'); ?></h1>
                <?php if (isset($msg1)) { ?>
                  <div class="alert alert--warning" role="alert">
                    <svg class="icon"><use href="#i-alert"/></svg>
                    <div><?= $msg1; ?></div>
                  </div>
                <?php } ?>
                <div class="field">
                  <label for="user_id" class="label"><?= bookfind_translate('Borrower'); ?></label>
                  <div class="select-search">
                    <input type="search" class="input" placeholder="<?= bookfind_translate('Search for a user...'); ?>" data-select-search />
                    <select id="user_id" name="user_id" class="select">
                      <option value=""><?= bookfind_translate('--- Select a user ---'); ?></option>
                      <?php include ROOT_PATH . '/gestion/actions/users/list-usersWithClass.php'; ?>
                    </select>
                  </div>
                </div>
                <div class="field">
                  <label for="date" class="label"><?= bookfind_translate('Return date'); ?></label>
                  <input type="date" class="input" id="date" value="<?= $dateIn30Days; ?>" name="date" required />
                </div>
                <div class="field">
                  <input type="submit" name="validateAdd" value="<?= bookfind_translate('Add the loan'); ?>" class="btn btn--primary" />
                </div>
                <input type="hidden" name="book_id" value="<?= htmlspecialchars($_GET['id']); ?>" />
              </div>
            </div>
          </form>

        <?php } elseif (($booksInfos['status'] ?? null) == 1) {
          if (isset($_GET['id']) and !empty($_GET['id'])) { ?>

            <!-- Edit return date -->
            <form action="<?= url(ltrim(str_replace(BASE_URL, '', $_SERVER['SCRIPT_NAME']), '/')) . (!empty($_SERVER['QUERY_STRING']) ? '?' . htmlspecialchars($_SERVER['QUERY_STRING'], ENT_QUOTES, 'UTF-8') : ''); ?>" method="post">
              <?= csrf_field(); ?>
              <div class="card">
                <div class="card__body">
                  <h1 class="card__title"><?= bookfind_translate('Edit the return date'); ?></h1>
                  <?php if (isset($_GET['success'])) { ?>
                    <div class="alert alert--success" role="alert">
                      <svg class="icon"><use href="#i-check"/></svg>
                      <div><?= bookfind_translate('Due date modified successfully!'); ?></div>
                    </div>
                  <?php } ?>
                  <div class="field">
                    <label for="updateDate" class="label"><?= bookfind_translate('New return date'); ?></label>
                    <input type="date" class="input" id="updateDate" name="date" value="<?= htmlspecialchars($loanInfos['due_date'] ?? '') ?>" required />
                  </div>
                  <div class="field">
                    <input type="submit" name="validateUpdate" value="<?= bookfind_translate('Save'); ?>" class="btn btn--primary" />
                  </div>
                  <input type="hidden" name="id" value="<?= $_GET['id'] ?>" />
                  <input type="hidden" name="user_id" value="<?= $_GET['user_id'] ?>" />
                </div>
              </div>
            </form>

            <!-- Return the loan -->
            <form action="<?= url(ltrim(str_replace(BASE_URL, '', $_SERVER['SCRIPT_NAME']), '/')) . (!empty($_SERVER['QUERY_STRING']) ? '?' . htmlspecialchars($_SERVER['QUERY_STRING'], ENT_QUOTES, 'UTF-8') : ''); ?>" method="post">
              <?= csrf_field(); ?>
              <div class="card">
                <div class="card__body">
                  <h1 class="card__title"><?= bookfind_translate('Return the loan'); ?></h1>
                  <div class="field">
                    <input type="submit" name="validateReturn" value="<?= bookfind_translate('Return the loan'); ?>" class="btn btn--success" />
                  </div>
                  <input type="hidden" name="id" value="<?= $_GET['id'] ?>" />
                  <input type="hidden" name="user_id" value="<?= $_GET['user_id'] ?>" />
                </div>
              </div>
            </form>

          <?php } else {
            echo bookfind_translate('Missing user ID.');
          }
        } ?>
      </div>
    </div>
  </main>
  <?php include ROOT_PATH . '/includes/footer.php'; ?>
</body>

</html>
