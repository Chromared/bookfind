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
    require '../actions/books/showOneBookAction.php';
    require 'actions/books/updateEmprunt.php';
    if($booksInfos['statut'] == 1){ require 'actions/books/showOneEmprunt.php'; }
    require 'actions/books/addEmpruntAction.php';
    require 'actions/books/returnEmprunt.php';

    $dateDans30Jours = date('Y-m-d', strtotime('+30 days')); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un emprunt</title>
    <?php include '../includes/header.php'; ?>
</head>
<body>
    <?php include 'includes/navbar.php'; ?>
    <br>
    <?php if($booksInfos['statut'] == 0 OR $booksInfos['statut'] == 2){ ?>
    <form method="post">
        <div class="container mt-3">
          <div class="d-flex justify-content-center mt-4">
            <div class="card text-center mb-3" style="width: 50rem;">
              <div class="card-body">
                <h5 class="card-title">Ajouter un emprunt</h5>
                <?php if(isset($msg1)){ ?>
                  <div class="alert alert-warning d-flex align-items-center justify-content-center" role="alert">
                    <i class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2"></i>
                    <div>
                      <?= $msg1; ?>
                    </div>
                  </div>
                <?php } ?>
                <div class="mb-3">
                  <label for="card" class="form-label">N° de carte de l'emprunteur</label>
                  <input type="number" class="form-control" name="card" id="card" min="0" max="99999999" autofocus required/>
                </div>
                <div class="mb-3">
                    <label for="date" class="form-label">À rendre pour le</label>
                    <input type="date" class="form-control" id="date" value="<?= $dateDans30Jours; ?>" name="date" required/>
                </div>
                <div class="mb-3">
                    <input type="submit" name="validateAdd" value="Ajouter l'emprunt" class="btn btn-primary"/>
                </div>
                <input type="hidden" name="id_book" value="<?= htmlspecialchars($_GET['id']); ?>" />
              </div>
            </div>
          </div>
        </div>
    </form>

    <?php } elseif($booksInfos['statut'] == 1){
        if(isset($_GET['card']) AND !empty($_GET['card'])){ ?>

    <!-- Modifier la date de retour -->
    <form method="post">
        <div class="container mt-3">
          <div class="d-flex justify-content-center mt-4">
            <div class="card text-center mb-3" style="width: 50rem;">
              <div class="card-body">
                <h5 class="card-title">Modifier la date de retour</h5>
                <?php if(isset($_GET['success'])){ ?>
                  <div class="alert alert-success d-flex align-items-center justify-content-center" role="alert">
                    <i class="bi bi-check-circle-fill flex-shrink-0 me-2"></i>
                    <div>
                      Date de retour modifiée avec succès !
                    </div>
                  </div>
                <?php } ?>
                <div class="mb-3">
                    <label for="updateDate" class="form-label">Nouvelle date de retour</label>
                    <input type="date" class="form-control" id="updateDate" name="date" value="<?= $empruntInfos['date_futur_retour'] ?>" required/>
                </div>
                <div class="mb-3">
                    <input type="submit" name="validateUpdate" value="Enregistrer" class="btn btn-primary"/>
                </div>
                <input type="hidden" name="id" value="<?= $_GET['id'] ?>" />
                <input type="hidden" name="card" value="<?= $_GET['card'] ?>" />
              </div>
            </div>
          </div>
        </div>
    </form>

    <!-- Retourner l'emprunt -->
    <form method="post">
        <div class="container mt-3">
          <div class="d-flex justify-content-center mt-4">
            <div class="card text-center mb-3" style="width: 50rem;">
              <div class="card-body">
                <h5 class="card-title">Retourner l'emprunt</h5>
                <div class="mb-3">
                    <input type="submit" name="validateReturn" value="Retourner l'emprunt" class="btn btn-success"/>
                </div>
                <input type="hidden" name="id" value="<?= $_GET['id'] ?>" />
                <input type="hidden" name="card" value="<?= $_GET['card'] ?>" />
              </div>
            </div>
          </div>
        </div>
    </form>

    <?php } else {
        echo 'N° de carte de l\'utilisateur manquant.';
    } } ?>
</body>
</html>
