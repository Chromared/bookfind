<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2025 Chromared
?>

<?php session_start();
    require 'actions/database.php';
    require 'actions/books/showOneBookAction.php';
    require 'actions/books/showOneEmprunt.php';
    require 'actions/functions/conversionDate.php';
    require 'actions/functions/conversionDateHour.php';
    require 'actions/functions/colorDateEmpruntFunction.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informations sur le livre</title>
    <?php include 'includes/header.php'; ?>
</head>
<body>
  <?php include 'includes/navbar.php'; ?>
  <div class="container mt-3">
    <div class="d-flex justify-content-center mt-4">
      <div class="card text-center" style="width: 50rem;">
        <div class="card-body">
          <h5 class="card-title"><?= htmlspecialchars($booksInfos['titre']); ?></h5>
          <h6 class="card-subtitle mb-2 text-body-secondary"><?= htmlspecialchars($booksInfos['auteur']); ?></h6>
          <p class="card-text"><?= htmlspecialchars($booksInfos['resume']); ?></p>
          <ul class="list-group list-group-flush">
            <li class="list-group-item">ID n°<?= htmlspecialchars($booksInfos['id']); ?></li>
            <li class="list-group-item">ISBN : <?= htmlspecialchars($booksInfos['isbn']); ?></li>
            <li class="list-group-item">Éditeur : <?= htmlspecialchars($booksInfos['editeur']); ?></li>
            <li class="list-group-item">Type : <?= htmlspecialchars($booksInfos['type']); ?></li>
            <?php if(!empty($booksInfos['genre'])){ ?>
              <li class="list-group-item">Genre : <?= htmlspecialchars($booksInfos['genre']); ?></li>
            <?php } ?>
            <?php if(!empty($booksInfos['id_unique'])){ ?>
              <li class="list-group-item">Identifiant unique : <?php echo htmlspecialchars($booksInfos['id_unique']); ?></li>
            <?php } ?>
            <?php if(!empty($booksInfos['serie'])){ ?>
              <li class="list-group-item">Tome <?= htmlspecialchars($booksInfos['tome']); ?> de la série <?= htmlspecialchars($booksInfos['serie']); ?></li>
            <?php } ?>
          </ul>
          <?php if($booksInfos['statut'] == 1){ ?>
            <ul class="list-group list-group-flush">
              <li class="list-group-item">Emprunté par <?= htmlspecialchars($emprunt['firstname_name']); ?></li>
              <li class="list-group-item">Retour prévu le <?php ColorDateEmprunt($emprunt['date_futur_retour']); ?></li>
            </ul>
          <?php } ?>
          <div class="btn-group" role="group">
            <?php if(isset($_SESSION['auth']) AND $_SESSION['grade'] != 0){ ?>
              <a href="gestion/update-book.php?id=<?= htmlspecialchars($booksInfos['id']); ?>" class="btn btn-primary">Modifier</a>
              <a href="gestion/emprunt.php?id=<?= htmlspecialchars($booksInfos['id']); ?><?php if($booksInfos['statut'] == 1){ echo '&card=' . htmlspecialchars($emprunt['card_emprunteur']); } ?>" class="btn btn-success">Emprunt</a>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>