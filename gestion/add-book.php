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
<br />
<p>Les champs marqués d'une * sont obligatoires.</p>
<?php if(isset($msg)){ echo '<p>' . $msg . '</p>'; } ?>
<br />

<div class="update-part"><h4>Ajouter un livre</h4>
<form method="post" autocomplete="off">

<input placeholder="ISBN*" type="number" id="isbn" name="isbn" list="isbns" min="0000000001" max="9999999999999" autofocus required/><datalist id="isbns"><?php include 'actions/books/list-isbns.php'; ?></datalist><br />
<input placeholder="Titre*" type="text" id="title" name="title" required/><br />
<input placeholder="Auteur*" type="text" id="author" name="author" list="authors" required/><datalist id="authors"><?php include 'actions/books/list-authors.php'; ?></datalist><br />
<input placeholder="Type*" type="text" id="type" name="type" list="types" required/><datalist id="types"><?php include 'actions/books/list-types.php'; ?></datalist><br />
<input placeholder="Éditeur*" type="text" itemid="editeur" name="editeur" id="editeur" list="publishers" required/><datalist id="publishers"><?php include 'actions/books/list-publishers.php'; ?></datalist><br />
<textarea placeholder="Résumé" id="resume" name="resume"></textarea><br />
<input placeholder="Identifiant unique" type="text" id="id_u" name="id_unique"/><br />
<input placeholder="Genre" type="text" id="genre" name="genre" list="genres"/><datalist id="genres"><?php include 'actions/books/list-genres.php'; ?></datalist><br />
<input placeholder="Série" type="text" id="serie" name="serie" list="series"/><datalist id="series"><?php include 'actions/books/list-series.php'; ?></datalist><br />
<input placeholder="Tome (n°)" type="number" id="tome" name="tome" min="0"/><br />
<input type="submit" name="validate" value="Enregistrer"/>

</form>
</div>

<script>
document.getElementById('isbn').addEventListener('keydown', function(event) {
    if (event.key === 'Enter') {
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