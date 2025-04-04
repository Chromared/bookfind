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
            <div class="alert alert-primary d-flex align-items-center" role="alert">
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
              <input type="number" name="isbn" class="form-control" placeholder="ISBN*" value="<?= htmlspecialchars($booksInfos['isbn']); ?>" min="1000000000" max="9999999999999" autofocus required/>
            </div>
            <div class="mb-3">
              <input type="text" name="title" class="form-control" placeholder="Titre*" value="<?= htmlspecialchars($booksInfos['titre']); ?>" required/>
            </div>
            <div class="mb-3">
              <input type="text" name="author" class="form-control" placeholder="Auteur*" value="<?= htmlspecialchars($booksInfos['auteur']); ?>" required/>
            </div>
            <div class="mb-3">
              <input type="text" name="type" class="form-control" placeholder="Type*" value="<?= htmlspecialchars($booksInfos['type']); ?>" required/>
            </div>
            <div class="mb-3">
              <input type="text" name="editeur" class="form-control" placeholder="Editeur*" value="<?= htmlspecialchars($booksInfos['editeur']); ?>" required/>
            </div>
            <div class="mb-3">
              <textarea name="resume" class="form-control" placeholder="Résumé" rows="1" value="<?= htmlspecialchars($booksInfos['resume']); ?>"></textarea>
            </div>
            <div class="mb-3">
              <input type="text" name="id_unique" class="form-control" placeholder="Identifiant unique" value="<?= htmlspecialchars($booksInfos['id_unique']); ?>"/>
            </div>
            <div class="mb-3">
              <input type="text" name="genre" class="form-control" placeholder="Genre" value="<?= htmlspecialchars($booksInfos['genre']); ?>"/>
            </div>
            <div class="mb-3">
              <input type="text" name="serie" class="form-control" placeholder="Série" value="<?= htmlspecialchars($booksInfos['serie']); ?>"/>
            </div>
            <div class="mb-3">
              <input type="number" name="tome" class="form-control" placeholder="Tome n°" value="<?php if(!empty($booksInfos['serie'])){ echo htmlspecialchars($booksInfos['tome']); } ?>"/>
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