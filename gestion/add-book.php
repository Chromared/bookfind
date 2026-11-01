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
require 'actions/books/addBooksAction.php'; ?>
<!DOCTYPE html>
<html lang="en" data-theme="<?php include '../actions/users/decodeThemeAction.php'; ?>">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BookFind — Add a book</title>
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
              <h1 class="card__title">Save a book</h1>
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
                <input type="number" name="isbn" id="isbn" class="input" list="isbns" min="1000000000" max="9999999999999" autofocus required />
                <datalist id="isbns">
                  <?php include 'actions/books/list-isbns.php'; ?>
                </datalist>
              </div>
              <div class="field">
                <label for="title" class="label">Title*</label>
                <input type="text" name="title" id="title" class="input" required />
              </div>
              <div class="field">
                <label for="author" class="label">Author*</label>
                <input type="text" name="author" id="author" class="input" list="authors" required />
                <datalist id="authors">
                  <?php include 'actions/books/list-authors.php'; ?>
                </datalist>
              </div>
              <div class="field">
                <label for="type" class="label">Type*</label>
                <input type="text" name="type" id="type" class="input" list="types" required />
                <datalist id="types">
                  <?php include 'actions/books/list-types.php'; ?>
                </datalist>
              </div>
              <div class="field">
                <label for="publisher" class="label">Publisher*</label>
                <input type="text" name="publisher" id="publisher" class="input" list="publishers" required />
                <datalist id="publishers">
                  <?php include 'actions/books/list-publishers.php'; ?>
                </datalist>
              </div>
              <div class="field">
                <label for="summary" class="label">Summary</label>
                <textarea name="summary" id="summary" class="textarea" rows="1"></textarea>
              </div>
              <div class="field">
                <label for="unique_id" class="label">Unique identifier</label>
                <input type="text" name="unique_id" id="unique_id" class="input" />
              </div>
              <div class="field">
                <label for="genre" class="label">Genre</label>
                <input type="text" name="genre" id="genre" class="input" list="genres" />
                <datalist id="genres">
                  <?php include 'actions/books/list-genres.php'; ?>
                </datalist>
              </div>
              <div class="field">
                <label for="series" class="label">Series</label>
                <input type="text" name="series" id="series" class="input" list="series" />
                <datalist id="series">
                  <?php include 'actions/books/list-series.php'; ?>
                </datalist>
              </div>
              <div class="field">
                <label for="volume" class="label">Volume no.</label>
                <input type="number" name="volume" id="volume" class="input" />
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

                alert("Information retrieved successfully!");
              } else {
                alert("No information found for this ISBN.");
              }
            })
            .catch(error => {
              console.error("Error while retrieving data: ", error);
              alert("An error occurred during the search. Make sure the ISBN is valid.");
            });
        } else {
          alert("Please enter a valid 10 or 13 character ISBN.");
        }
      }
    });
  </script>
  <?php include '../includes/footer.php'; ?>
</body>

</html>
