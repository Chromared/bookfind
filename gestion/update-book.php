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
    require 'actions/books/updateBooksAction.php';
    require '../actions/books/showOneBookAction.php'; ?>
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
              <input type="number" name="isbn" id="isbn" class="form-control" value="<?= htmlspecialchars($booksInfos['isbn']); ?>" min="1000000000" max="9999999999999" autofocus required/>
            </div>
            <div class="mb-3">
              <label for="title" class="form-label text-start d-block">Titre*</label>
              <input type="text" name="title" id="title" class="form-control" value="<?= htmlspecialchars($booksInfos['titre']); ?>" required/>
            </div>
            <div class="mb-3">
              <label for="author" class="form-label text-start d-block">Auteur*</label>
              <input type="text" name="author" id="author" class="form-control" value="<?= htmlspecialchars($booksInfos['auteur']); ?>" required/>
            </div>
            <div class="mb-3">
              <label for="type" class="form-label text-start d-block">Type*</label>
              <input type="text" name="type" id="type" class="form-control" value="<?= htmlspecialchars($booksInfos['type']); ?>" required/>
            </div>
            <div class="mb-3">
              <label for="editeur" class="form-label text-start d-block">Editeur*</label>
              <input type="text" name="editeur" id="editeur" class="form-control" value="<?= htmlspecialchars($booksInfos['editeur']); ?>" required/>
            </div>
            <div class="mb-3">
              <label for="resume" class="form-label text-start d-block">Résumé</label>
              <textarea name="resume" id="resume" class="form-control" rows="1"><?= htmlspecialchars($booksInfos['resume']); ?></textarea>
            </div>
            <div class="mb-3">
              <label for="id_unique" class="form-label text-start d-block">Identifiant unique</label>
              <input type="text" name="id_unique" id="id_unique" class="form-control" value="<?= htmlspecialchars($booksInfos['id_unique']); ?>"/>
            </div>
            <div class="mb-3">
              <label for="genre" class="form-label text-start d-block">Genre</label>
              <input type="text" name="genre" id="genre" class="form-control" value="<?= htmlspecialchars($booksInfos['genre']); ?>"/>
            </div>
            <div class="mb-3">
              <label for="serie" class="form-label text-start d-block">Série</label>
              <input type="text" name="serie" id="serie" class="form-control" value="<?= htmlspecialchars($booksInfos['serie']); ?>"/>
            </div>
            <div class="mb-3">
              <label for="tome" class="form-label text-start d-block">Tome n°</label>
              <input type="number" name="tome" id="tome" class="form-control" value="<?php if(!empty($booksInfos['serie'])){ echo htmlspecialchars($booksInfos['tome']); } ?>"/>
            </div>
            <div class="mb-3">
              <input type="submit" name="validate" class="btn btn-primary" value="Enregistrer" />
            </div>
          </div>
        </div>
      </div>
    </div>
</form>
</body>
</html>