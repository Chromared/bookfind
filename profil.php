<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2025 Chromared
?>

<?php require 'actions/database.php';
    require 'actions/users/securityAction.php';
    if (isset($_GET['id']) AND !empty($_GET['id'])) { require 'actions/users/showOneUserProfilAction.php'; }else{ die('La variable URL contenant l\'ID de l\'utilisateur est absente ou vide.'); }
    require 'actions/functions/transfoGradeIntVersText.php';
    require 'actions/functions/conversionDateHour.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <?php include 'includes/header.php' ?>
</head>
<body>
    <?php include 'includes/navbar.php'?>
    <?php if($selectInfosFromUsers->rowCount() === 1){ ?>
      <div class="container mt-3">
        <div class="d-flex justify-content-center mt-4">
          <div class="card text-center mb-3" style="width: 50rem;">
            <div class="card-body">
              <h5 class="card-title"><?= htmlspecialchars($usersInfos['prenom']); ?> <?= htmlspecialchars($usersInfos['nom']); ?></h4></h5>
              <h6 class="card-subtitle mb-2 text-body-secondary"><?= htmlspecialchars($usersInfos['carte']); ?></h6>
              <ul class="list-group list-group-flush">
                  <li class="list-group-item">ID n°<?= htmlspecialchars($usersInfos['id']); ?></li>
                  <li class="list-group-item">En classe de <?= htmlspecialchars($usersInfos['classe']); ?></li>
                  <li class="list-group-item">Inscris le <?php ConversionDateHour($usersInfos['datetime']); ?></li>
                  <?php if ($usersInfos['id'] == $_SESSION['id']){ ?>
                      <li class="list-group-item">Grade : <?php Grade($usersInfos['grade']); ?></li>
                      <li class="list-group-item">
                          <a href="actions/users/logoutAction.php" class="btn btn-secondary">Déconnexion</a>
                          <a href="updateProfil.php?id=<?= htmlspecialchars($_SESSION['id']); ?>" class="btn btn-primary">Modifier</a>
                      </li>
                  <?php } if($_SESSION['grade'] != 0 AND $_SESSION['id'] != $usersInfos['id']){ ?>
                      <li class="list-group-item">
                          <a href="gestion/user-emprunts.php?card=<?= htmlspecialchars($usersInfos['carte']) ?>" class="btn btn-secondary">Déconnexion</a>
                          <a href="gestion/update-user.php?id=<?= htmlspecialchars($usersInfos['id']) ?>" class="btn btn-primary">Modifier</a>
                      </li>
                  <?php } ?>
              </ul>
            </div>
          </div>
        </div>
      </div>
<?php }else{ echo 'Aucun utilisateur avec l\'id n°' . htmlspecialchars($_GET['id']) . ' n\'a été trouvé.'; } ?>
</body>
</html>