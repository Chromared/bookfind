<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2025 Chromared
?>

<?php require '../actions/database.php'; 
    require 'actions/users/securityAction.php';
    require 'actions/users/securityAdminAction.php';
    require '../actions/functions/logFunction.php';
    require 'actions/books/addBooksAction.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enregistrer un livre</title>
    <?php include '../includes/header.php'; ?>
</head>
<body>
<?php include 'includes/navbar.php'; ?>
<form method="POST" autocomplete="off">
    <div class="container mt-3">
      <div class="d-flex justify-content-center mt-4">
        <div class="card text-center mb-3" style="width: 50rem;">
          <div class="card-body">
            <h5 class="mb-3">Enregistrer un livre</h5>
            <div class="alert alert-primary d-flex align-items-center justify-content-center" role="alert">
              <i class="bi bi-info-circle-fill flex-shrink-0 me-2"></i>
              <div>
                Les champs marqués d'une * doivent être remplis.
              </div>
            </div>
            <?php if(isset($errorMsg)){ ?>
              <div class="alert alert-warning d-flex align-items-center justify-content-center" role="alert">
                <i class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2"></i>
                <div>
                  <?= $errorMsg; ?>
                </div>
              </div>
            <?php }elseif (isset($successMsg)) { ?>
              <div class="alert alert-success d-flex align-items-center justify-content-center" role="alert">
                <i class="bi bi-check-circle-fill flex-shrink-0 me-2"></i>
                <div>
                  Livre enregistré avec succès
                </div>
              </div>
            <?php } ?>
            <div class="mb-3">
              <label for="isbn" class="form-label text-start d-block">ISBN*</label>
              <input type="number" name="isbn" id="isbn" class="form-control" list="isbns" min="1000000000" max="9999999999999" autofocus required/>
              <datalist id="isbns">
                <?php include 'actions/books/list-isbns.php'; ?>
              </datalist>
            </div>
            <div class="mb-3">
              <label for="title" class="form-label text-start d-block">Titre*</label>
              <input type="text" name="title" id="title" class="form-control" required/>
            </div>
            <div class="mb-3">
              <label for="author" class="form-label text-start d-block">Auteur*</label>
              <input type="text" name="author" id="author" class="form-control" list="authors" required/>
              <datalist id="authors">
                <?php include 'actions/books/list-authors.php'; ?>
              </datalist>
            </div>
            <div class="mb-3">
              <label for="type" class="form-label text-start d-block">Type*</label>
              <input type="text" name="type" id="type" class="form-control" list="types" required/>
              <datalist id="types">
                <?php include 'actions/books/list-types.php'; ?>
              </datalist>
            </div>
            <div class="mb-3">
              <label for="editeur" class="form-label text-start d-block">Editeur*</label>
              <input type="text" name="editeur" id="editeur" class="form-control" list="publishers" required/>
              <datalist id="publishers">
                <?php include 'actions/books/list-publishers.php'; ?>
              </datalist>
            </div>
            <div class="mb-3">
              <label for="resume" class="form-label text-start d-block">Résumé</label>
              <textarea name="resume" id="resume" class="form-control" rows="1"></textarea>
            </div>
            <div class="mb-3">
              <label for="id_unique" class="form-label text-start d-block">Identifiant unique</label>
              <input type="text" name="id_unique" id="id_unique" class="form-control" />
            </div>
            <div class="mb-3">
              <label for="genre" class="form-label text-start d-block">Genre</label>
              <input type="text" name="genre" id="genre" class="form-control" list="genres" />
              <datalist id="genres">
                <?php include 'actions/books/list-genres.php'; ?>
              </datalist>
            </div>
            <div class="mb-3">
              <label for="serie" class="form-label text-start d-block">Série</label>
              <input type="text" name="serie" id="serie" class="form-control" list="series"/>
              <datalist id="series">
                <?php include 'actions/books/list-series.php'; ?>
              </datalist>
            </div>
            <div class="mb-3">
              <label for="tome" class="form-label text-start d-block">Tome n°</label>
              <input type="number" name="tome" id="tome" class="form-control" />
            </div>
            <div class="mb-3">
              <input type="submit" name="validate" class="btn btn-primary" value="Enregistrer" />
            </div>
          </div>
        </div>
      </div>
    </div>
</form>
<script>
document.getElementById('isbn').addEventListener('keydown', function(event) {
    if (event.key === 'Enter' || event.key === 'Tab') {
        // Empêche l'envoi du formulaire
        event.preventDefault();
        
        // Récupère l'ISBN
        const isbn = document.getElementById('isbn').value;
        
        // Vérifie que l'ISBN est valide
        if (isbn.length === 10 || isbn.length === 13) {  // ISBN-10 ou ISBN-13
            fetch(`https://www.googleapis.com/books/v1/volumes?q=isbn:${isbn}`)
                .then(response => response.json())
                .then(data => {
                    if (data.items && data.items.length > 0) {
                        const book = data.items[0].volumeInfo;

                        // Vérifie si les informations sont disponibles. On laisse vide si on ne peut pas récupérer les informations associées.
                        const title = book.title || '';
                        const author = book.authors ? book.authors.join(', ') : '';
                        const publisher = book.publisher || '';
                        const description = book.description || '';
                        const genre = book.categories ? book.categories.join(', ') : '';
                        const series = book.series ? book.series.join(', ') : '';

                        // Complète les champs du formulaire avec les données récupérées
                        document.getElementById('title').value = title;
                        document.getElementById('author').value = author;
                        document.getElementById('editeur').value = publisher;
                        document.getElementById('resume').value = description;
                        document.getElementById('serie').value = series;

                        alert("Informations récupérées avec succès !");
                    } else {
                        alert("Aucune information trouvée pour cet ISBN.");
                    }
                })
                .catch(error => {
                    console.error("Erreur lors de la récupération des données : ", error);
                    alert("Une erreur est survenue lors de la recherche. Assurez-vous que l'ISBN est valide.");
                });
        } else {
            alert("Veuillez entrer un ISBN valide de 10 ou 13 caractères.");
        }
    }
});
</script>
</body>
</html>