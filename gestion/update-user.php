<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2025 Chromared
?>

<?php if(isset($_GET['id']) AND !empty($_GET['id'])){ ?>
<?php require '../actions/database.php'; 
    require 'actions/users/securityAction.php';
    require 'actions/users/securityAdminAction.php';
    require '../actions/functions/logFunction.php';
    require '../actions/users/showOneUserProfilAction.php';
    require '../actions/functions/selected.php';
    require '../actions/functions/transfoGradeIntVersText.php';
    require 'actions/users/updateInfoPersoAction.php';
    require 'actions/users/updateInfoScoAction.php';
    require 'actions/users/updateGradeAction.php';
    require 'actions/users/updateMdpAction.php';
    require 'actions/users/deleteAccountAction1.php';
    require 'actions/users/deleteAccountAction2.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mise à jour d'un compte utilisateur</title>
    <?php include '../includes/header.php' ?>
</head>
<body>
<?php include 'includes/navbar.php'?>

<?php if(($_SESSION['grade'] != '1' AND $usersInfos['grade'] == '1') OR ($_SESSION['grade'] != '1' AND $_SESSION['grade'] != '2' AND $usersInfos['grade'] == '2')){echo '<p>Vous n\'avez pas le droit de modifier cet utilisateur.</p>';}else{ ?>

<form method="post">
    <div class="container mt-3">
      <div class="d-flex justify-content-center mt-4">
        <div class="card text-center mb-3" style="width: 50rem;">
          <div class="card-body">
            <h5 class="card-title">Informations personnelles</h5>
            <?php if(isset($errorMsg1)){ ?>
              <div class="alert alert-warning d-flex align-items-center justify-content-center" role="alert">
                <i class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2"></i>
                <div>
                  <?= $errorMsg1; ?>
                </div>
              </div>
            <?php } ?>
            <?php if(isset($_GET['msg1'])){ ?>
              <div class="alert alert-success d-flex align-items-center justify-content-center" role="alert">
                <i class="bi bi-check-circle-fill flex-shrink-0 me-2"></i>
                <div>
                  Vos modifications ont bien été enregistré.
                </div>
              </div>
            <?php } ?>
            <div class="mb-3">
              <input type="text" name="firstname" class="form-control" placeholder="Prénom" value="<?= htmlspecialchars($usersInfos['prenom']); ?>" required/>
            </div>
            <div class="mb-3">
              <input type="text" name="name" class="form-control" placeholder="Nom de famille" value="<?= htmlspecialchars($usersInfos['nom']); ?>" required/>
            </div>
            <div class="mb-3">
              <input type="submit" name="validateInfoPerso" class="btn btn-primary" value="Enregistrer" />
              <input type="reset" class="btn btn-secondary" value="Réinitialiser" />
            </div>
          </div>
        </div>
      </div>
    </div>
</form>

<form method="post">
    <div class="container mt-3">
      <div class="d-flex justify-content-center mt-4">
        <div class="card text-center mb-3" style="width: 50rem;">
          <div class="card-body">
            <h5 class="card-title">Informations scolaires</h5>
            <?php if(isset($errorMsg2)){ ?>
              <div class="alert alert-warning d-flex align-items-center justify-content-center" role="alert">
                <i class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2"></i>
                <div>
                  <?= $errorMsg2; ?>
                </div>
              </div>
            <?php } ?>
            <?php if(isset($_GET['msg2'])){ ?>
              <div class="alert alert-success d-flex align-items-center justify-content-center" role="alert">
                <i class="bi bi-check-circle-fill flex-shrink-0 me-2"></i>
                <div>
                  Vos modifications ont bien été enregistré.
                </div>
              </div>
            <?php } ?>
            <div class="mb-3">
              <select name="classe" class="form-select" required>
                <?php include '../actions/functions/recupClassesAndOptions.php'; ?>
              </select>
            </div>
            <div class="mb-3">
              <input type="submit" name="validateInfoSco" class="btn btn-primary" value="Enregistrer" />
              <input type="reset" class="btn btn-secondary" value="Réinitialiser" />
            </div>
          </div>
        </div>
      </div>
    </div>
</form>

<?php if($_SESSION['grade'] == '1' OR $_SESSION['grade'] == '2'){ ?>

    <form method="post">
    <div class="container mt-3">
      <div class="d-flex justify-content-center mt-4">
        <div class="card text-center mb-3" style="width: 50rem;">
          <div class="card-body">
            <h5 class="card-title">Grade</h5>
            <?php if(isset($errorMsg5)){ ?>
              <div class="alert alert-warning d-flex align-items-center justify-content-center" role="alert">
                <i class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2"></i>
                <div>
                  <?= $errorMsg5; ?>
                </div>
              </div>
            <?php } ?>
            <?php if(isset($_GET['msg5'])){ ?>
              <div class="alert alert-success d-flex align-items-center justify-content-center" role="alert">
                <i class="bi bi-check-circle-fill flex-shrink-0 me-2"></i>
                <div>
                  Vos modifications ont bien été enregistré.
                </div>
              </div>
            <?php } ?>
            <div class="mb-3">
              <select class="form-control" name="grade" ><option value="0" <?php Selected('0', $usersInfos['grade']); ?> >Aucun</option><option value="3" <?php Selected('3', $usersInfos['grade']); ?> >Assistant</option><option value="2" <?php Selected('2', $usersInfos['grade']); ?> >Gérant</option><?php if($_SESSION['grade'] == '1'){ ?><option value="1" <?php Selected('1', $usersInfos['grade']); ?> >Administrateur</option><?php } ?></select>
            </div>
            <div class="mb-3">
              <input type="submit" name="validateGrade" class="btn btn-primary" value="Enregistrer" />
              <input type="reset" class="btn btn-secondary" value="Réinitialiser" />
            </div>
          </div>
        </div>
      </div>
    </div>
</form>

<form method="post">
    <div class="container mt-3">
      <div class="d-flex justify-content-center mt-4">
        <div class="card text-center mb-3" style="width: 50rem;">
          <div class="card-body">
            <h5 class="card-title">Mot de passe</h5>
            <?php if(isset($errorMsg3)){ ?>
              <div class="alert alert-warning d-flex align-items-center justify-content-center" role="alert">
                <i class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2"></i>
                <div>
                  <?= $errorMsg3; ?>
                </div>
              </div>
            <?php } ?>
            <?php if(isset($_GET['msg3'])){ ?>
              <div class="alert alert-success d-flex align-items-center justify-content-center" role="alert">
                <i class="bi bi-check-circle-fill flex-shrink-0 me-2"></i>
                <div>
                  Vos modifications ont bien été enregistré.
                </div>
              </div>
            <?php } ?>
            <div class="mb-3">
              <input type="password" name="new-password" class="form-control" placeholder="Nouveau mot de passe" required/>
            </div>
            <div class="mb-3">
              <input type="password" name="confirm-new-password" class="form-control" placeholder="Confirmer le nouveau mot de passe" required/>
            </div>
            <div class="mb-3">
              <input type="submit" name="validateMdp" class="btn btn-primary" value="Enregistrer" />
            </div>
          </div>
        </div>
      </div>
    </div>
</form>

<form method="post">
  <div class="container mt-3">
    <div class="d-flex justify-content-center mt-4">
      <div class="card text-center mb-3" style="width: 50rem;">
        <div class="card-body">
          <h5 class="card-title">Supprimer le compte</h5>
          <?php if(isset($errorMsg4)){ ?>
            <div class="alert alert-warning d-flex align-items-center justify-content-center" role="alert">
              <i class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2"></i>
              <div>
                <?= $errorMsg4; ?>
              </div>
            </div>
          <?php } ?>
          <?php if(!isset($deleteAccount)){ ?>
            <div class="mb-3">
              <input type="submit" name="validateDelete1" class="btn btn-danger" value="Supprimer le compte" />
            </div>
          <?php }elseif(isset($deleteAccount)){ ?>
            <div class="alert alert-danger d-flex align-items-center justify-content-center" role="alert">
              <i class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2"></i>
              <div>
                Je confirme vouloir supprimer ce compte. Cette action est irréversible.
              </div>
            </div>
            <div class="mb-3">
              <input type="submit" value="Supprimer" name="validateDelete2" class="btn btn-danger" />
            </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</form>
<?php }} ?>
</body>
</html>
<?php } ?>