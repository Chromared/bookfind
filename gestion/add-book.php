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
require ROOT_PATH . '/gestion/actions/books/addBooksAction.php'; ?>
<!DOCTYPE html>
<html lang="<?= $GLOBALS['bookfindLocale'] === 'fr_FR' ? 'fr' : 'en'; ?>" data-theme="<?php include ROOT_PATH . '/actions/users/decodeThemeAction.php'; ?>">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= bookfind_translate('BookFind — Add a book'); ?></title>
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
              <h1 class="card__title"><?= bookfind_translate('Save a book'); ?></h1>
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
                <input type="number" name="isbn" id="isbn" class="input" list="isbns" min="1000000000" max="9999999999999" autofocus required />
                <datalist id="isbns">
                  <?php include ROOT_PATH . '/gestion/actions/books/list-isbns.php'; ?>
                </datalist>
              </div>
              <div class="field">
                <label for="title" class="label"><?= bookfind_translate('Title*'); ?></label>
                <input type="text" name="title" id="title" class="input" required />
              </div>
              <div class="field">
                <label for="author" class="label"><?= bookfind_translate('Author*'); ?></label>
                <input type="text" name="author" id="author" class="input" list="authors" required />
                <datalist id="authors">
                  <?php include ROOT_PATH . '/gestion/actions/books/list-authors.php'; ?>
                </datalist>
              </div>
              <div class="field">
                <label for="type" class="label"><?= bookfind_translate('Type*'); ?></label>
                <input type="text" name="type" id="type" class="input" list="types" required />
                <datalist id="types">
                  <?php include ROOT_PATH . '/gestion/actions/books/list-types.php'; ?>
                </datalist>
              </div>
              <div class="field">
                <label for="publisher" class="label"><?= bookfind_translate('Publisher*'); ?></label>
                <input type="text" name="publisher" id="publisher" class="input" list="publishers" required />
                <datalist id="publishers">
                  <?php include ROOT_PATH . '/gestion/actions/books/list-publishers.php'; ?>
                </datalist>
              </div>
              <div class="field">
                <label for="summary" class="label"><?= bookfind_translate('Summary'); ?></label>
                <textarea name="summary" id="summary" class="textarea" rows="1"></textarea>
              </div>
              <div class="field">
                <label for="unique_id" class="label"><?= bookfind_translate('Unique identifier'); ?></label>
                <input type="text" name="unique_id" id="unique_id" class="input" />
              </div>
              <div class="field">
                <label for="genre" class="label"><?= bookfind_translate('Genre'); ?></label>
                <input type="text" name="genre" id="genre" class="input" list="genres" />
                <datalist id="genres">
                  <?php include ROOT_PATH . '/gestion/actions/books/list-genres.php'; ?>
                </datalist>
              </div>
              <div class="field">
                <label for="series" class="label"><?= bookfind_translate('Series'); ?></label>
                <input type="text" name="series" id="series" class="input" list="series" />
                <datalist id="series">
                  <?php include ROOT_PATH . '/gestion/actions/books/list-series.php'; ?>
                </datalist>
              </div>
              <div class="field">
                <label for="volume" class="label"><?= bookfind_translate('Volume no.'); ?></label>
                <input type="number" name="volume" id="volume" class="input" />
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
  <script nonce="<?= htmlspecialchars($_SESSION['csp_nonce'] ?? '') ?>">
    document.getElementById('isbn').addEventListener('keydown', function(event) {
      if (event.key === 'Enter' || event.key === 'Tab') {
        // Prevent form submission
        event.preventDefault();

        // Get the ISBN
        const isbn = document.getElementById('isbn').value;

        // Check that the ISBN is valid
        if (isbn.length === 10 || isbn.length === 13) { // ISBN-10 or ISBN-13
          fetch(`https://www.googleapis.com/books/v1/volumes?q=isbn:${isbn}`)
            .then(response => response.json())
            .then(data => {
              if (data.items && data.items.length > 0) {
                const book = data.items[0].volumeInfo;

                // Check if information is available. Leave empty if unable to retrieve associated info.
                const title = book.title || '';
                const author = book.authors ? book.authors.join(', ') : '';
                const publisher = book.publisher || '';
                const description = book.description || '';
                const genre = book.categories ? book.categories.join(', ') : '';
                const series = book.series ? book.series.join(', ') : '';

                // Fill form fields with retrieved data
                document.getElementById('title').value = title;
                document.getElementById('author').value = author;
                document.getElementById('publisher').value = publisher;
                document.getElementById('summary').value = description;
                document.getElementById('series').value = series;

                alert(<?= json_encode(bookfind_translate('Information retrieved successfully!')); ?>);
              } else {
                alert(<?= json_encode(bookfind_translate('No information found for this ISBN.')); ?>);
              }
            })
            .catch(error => {
              console.error("Error while retrieving data: ", error);
              alert(<?= json_encode(bookfind_translate('An error occurred during the search. Make sure the ISBN is valid.')); ?>);
            });
        } else {
          alert(<?= json_encode(bookfind_translate('Please enter a valid 10 or 13 character ISBN.')); ?>);
        }
      }
    });
  </script>
  <?php include ROOT_PATH . '/includes/footer.php'; ?>
</body>

</html>
