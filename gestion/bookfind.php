<?php 
require '../actions/database.php';
require 'actions/users/securityAction.php';
require 'actions/users/securityAdminAction.php';
require '../actions/functions/logFunction.php';
require 'actions/others/updateDatabase.php';
require 'actions/others/addClasse.php';
require 'actions/others/updateClasse.php';
require 'actions/others/deleteClasse.php';

if ($_SESSION['grade'] != '1') {
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gérer BookFind</title>
  <?php include '../includes/header.php'; ?>
</head>
<body>
  <?php include 'includes/navbar.php'; ?>

  <!-- Connexion base de données -->
  <form method="POST" autocomplete="off">
    <div class="container mt-3">
      <div class="d-flex justify-content-center mt-4">
        <div class="card text-center mb-3" style="width: 50rem;">
          <div class="card-body">
            <h4 class="mb-3">Connexion à la base de données</h4>

            <div class="mb-3">
              <input type="text" name="host" class="form-control" placeholder="Hôte *" value="<?= $host; ?>" required />
            </div>
            <div class="mb-3">
              <input type="text" name="dbname" class="form-control" placeholder="Nom de la base de données *" value="<?= $dbname; ?>" required />
            </div>
            <div class="mb-3">
              <input type="text" name="user" class="form-control" placeholder="Nom d'utilisateur *" value="<?= $username; ?>" required />
            </div>
            <div class="mb-3">
              <input type="password" name="password" class="form-control" placeholder="Mot de passe" value="<?= $password; ?>" />
            </div>
            <div class="mb-3">
              <input type="submit" name="databaseValidate" class="btn btn-primary" value="Enregistrer" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>

  <!-- Ajouter une classe -->
  <form method="POST" autocomplete="off">
    <div class="container mt-3">
      <div class="d-flex justify-content-center">
        <div class="card text-center mb-3" style="width: 50rem;">
          <div class="card-body">
            <h4 class="mb-3">Ajouter une classe</h4>

            <?php if (isset($msgC1)) { ?>
              <div class="alert alert-warning d-flex align-items-center justify-content-center" role="alert">
                <i class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2"></i>
                <div><?= $msgC1; ?></div>
              </div>
            <?php } ?>

            <div class="mb-3">
              <input type="text" name="newClasse" class="form-control" placeholder="Nom de la classe *" required />
            </div>
            <div class="mb-3">
              <input type="submit" name="classeAddValidate" class="btn btn-success" value="Ajouter" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>

  <!-- Modifier une classe -->
  <form method="POST" autocomplete="off">
    <div class="container mt-3">
      <div class="d-flex justify-content-center">
        <div class="card text-center mb-3" style="width: 50rem;">
          <div class="card-body">
            <h4 class="mb-3">Modifier une classe</h4>

            <?php if (isset($msgC2)) { ?>
              <div class="alert alert-warning d-flex align-items-center justify-content-center" role="alert">
                <i class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2"></i>
                <div><?= $msgC2; ?></div>
              </div>
            <?php } ?>

            <div class="mb-3">
              <select name="existingClasse" class="form-select" required>
                <option value="">--- Sélectionner une classe ---</option>
                <?php include '../actions/functions/recupClassesAndOptions.php'; ?>
              </select>
            </div>
            <div class="mb-3">
              <input type="text" name="newClasseName" class="form-control" placeholder="Nouveau nom de la classe *" required />
            </div>
            <div class="mb-3">
              <input type="submit" name="classeUpdateValidate" class="btn btn-primary" value="Modifier" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>

  <!-- Supprimer une classe -->
  <form method="POST" autocomplete="off">
    <div class="container mt-3">
      <div class="d-flex justify-content-center">
        <div class="card text-center mb-5" style="width: 50rem;">
          <div class="card-body">
            <h4 class="mb-3">Supprimer une classe</h4>

            <?php if (isset($msgC3)) { ?>
              <div class="alert alert-warning d-flex align-items-center justify-content-center" role="alert">
                <i class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2"></i>
                <div><?= $msgC3; ?></div>
              </div>
            <?php } ?>

            <div class="mb-3">
              <select name="existingClasse2" class="form-select" required>
                <option value="">--- Sélectionner une classe ---</option>
                <?php include '../actions/functions/recupClassesAndOptions.php'; ?>
              </select>
            </div>
            <div class="mb-3">
              <input type="submit" name="classeDeleteValidate" class="btn btn-danger" value="Supprimer" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</body>
</html>
