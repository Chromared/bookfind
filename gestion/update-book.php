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
require ROOT_PATH . '/actions/functions/logFunction.php';
require ROOT_PATH . '/gestion/actions/books/updateBooksAction.php';
require ROOT_PATH . '/actions/books/showOneBookAction.php'; ?>
<!DOCTYPE html>
<html lang="<?= $GLOBALS['bookfindLocale'] === 'fr_FR' ? 'fr' : 'en'; ?>" data-theme="<?php include ROOT_PATH . '/actions/users/decodeThemeAction.php'; ?>">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= bookfind_translate('BookFind — Update a book'); ?></title>
  <?php include ROOT_PATH . '/includes/header.php'; ?>
</head>

<body class="admin">
  <?php include ROOT_PATH . '/gestion/includes/navbar.php'; ?>
  <main class="page">
    <div class="container">
      <div class="narrow">
        <form action="<?= url(ltrim(str_replace(BASE_URL, '', $_SERVER['SCRIPT_NAME']), '/')) . (!empty($_SERVER['QUERY_STRING']) ? '?' . htmlspecialchars($_SERVER['QUERY_STRING'], ENT_QUOTES, 'UTF-8') : ''); ?>" method="POST" autocomplete="off">
          <?= csrf_field(); ?>
          <div class="card">
            <div class="card__body">
              <div class="alert alert--info" role="alert">
                <svg class="icon"><use href="#i-info"/></svg>
                <div><?= bookfind_translate('Fields marked with * are required.'); ?></div>
              </div>
              <?php if (isset($errorMsg)) { ?>
                <div class="alert alert--warning" role="alert">
                  <svg class="icon"><use href="#i-alert"/></svg>
                  <div><?= $errorMsg; ?></div>
                </div>
              <?php } elseif (isset($successMsg)) { ?>
                <div class="alert alert--success" role="alert">
                  <svg class="icon"><use href="#i-check"/></svg>
                  <div><?= bookfind_translate('Book saved successfully'); ?></div>
                </div>
              <?php } ?>
              <div class="field">
                <label for="isbn" class="label"><?= bookfind_translate('ISBN*'); ?></label>
                <input type="number" name="isbn" id="isbn" class="input" value="<?= htmlspecialchars($booksInfos['isbn'] ?? ''); ?>" min="1000000000" max="9999999999999" autofocus required />
              </div>
              <div class="field">
                <label for="title" class="label"><?= bookfind_translate('Title*'); ?></label>
                <input type="text" name="title" id="title" class="input" value="<?= htmlspecialchars($booksInfos['title'] ?? ''); ?>" required />
              </div>
              <div class="field">
                <label for="author" class="label"><?= bookfind_translate('Author*'); ?></label>
                <input type="text" name="author" id="author" class="input" value="<?= htmlspecialchars($booksInfos['author'] ?? ''); ?>" required />
              </div>
              <div class="field">
                <label for="type" class="label"><?= bookfind_translate('Type*'); ?></label>
                <input type="text" name="type" id="type" class="input" value="<?= htmlspecialchars($booksInfos['type'] ?? ''); ?>" required />
              </div>
              <div class="field">
                <label for="publisher" class="label"><?= bookfind_translate('Publisher*'); ?></label>
                <input type="text" name="publisher" id="publisher" class="input" value="<?= htmlspecialchars($booksInfos['publisher'] ?? ''); ?>" required />
              </div>
              <div class="field">
                <label for="summary" class="label"><?= bookfind_translate('Summary'); ?></label>
                <textarea name="summary" id="summary" class="textarea" rows="1"><?= htmlspecialchars($booksInfos['summary'] ?? ''); ?></textarea>
              </div>
              <div class="field">
                <label for="unique_id" class="label"><?= bookfind_translate('Unique identifier'); ?></label>
                <input type="text" name="unique_id" id="unique_id" class="input" value="<?= htmlspecialchars($booksInfos['unique_id'] ?? ''); ?>" />
              </div>
              <div class="field">
                <label for="genre" class="label"><?= bookfind_translate('Genre'); ?></label>
                <input type="text" name="genre" id="genre" class="input" value="<?= htmlspecialchars($booksInfos['genre'] ?? ''); ?>" />
              </div>
              <div class="field">
                <label for="series" class="label"><?= bookfind_translate('Series'); ?></label>
                <input type="text" name="series" id="series" class="input" value="<?= htmlspecialchars($booksInfos['series'] ?? ''); ?>" />
              </div>
              <div class="field">
                <label for="volume" class="label"><?= bookfind_translate('Volume no.'); ?></label>
                <input type="number" name="volume" id="volume" class="input" value="<?php if (!empty($booksInfos['series'] ?? '')) {
                                                                                    echo htmlspecialchars($booksInfos['volume'] ?? '');
                                                                                  } ?>" />
              </div>
              <div class="field">
                <input type="submit" name="validate" class="btn btn--primary" value="<?= bookfind_translate('Save'); ?>" />
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </main>
  <?php include ROOT_PATH . '/includes/footer.php'; ?>
</body>

</html>
