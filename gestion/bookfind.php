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
            <h5 class="card-title">Connexion à la base de données</h5>
            <div class="alert alert-primary d-flex align-items-center justify-content-center" role="alert">
              <i class="bi bi-info-circle-fill flex-shrink-0 me-2"></i>
              <div>
                Les champs marqués d'une * doivent être remplis.
              </div>
            </div>
            <div class="mb-3">
              <label for="host" class="form-label text-start d-block">Hôte*</label>
              <input type="text" name="host" id="host" class="form-control" value="<?= $host; ?>" required />
            </div>
            <div class="mb-3">
              <label for="dbname" class="form-label text-start d-block">Nom de la base de données*</label>
              <input type="text" name="dbname" id="dbname" class="form-control" value="<?= $dbname; ?>" placeholder="bookfind" required />
            </div>
            <div class="mb-3">
              <label for="user" class="form-label text-start d-block">Nom d'utilisateur*</label>
              <input type="text" name="user" id="user" class="form-control" value="<?= $username; ?>" required />
            </div>
            <div class="mb-3">
              <label for="password" class="form-label text-start d-block">Mot de passe</label>
              <input type="password" name="password" id="password" class="form-control" value="<?= $password; ?>" />
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
            <h5 class="card-title">Ajouter une classe</h5>
            <div class="alert alert-primary d-flex align-items-center justify-content-center" role="alert">
              <i class="bi bi-info-circle-fill flex-shrink-0 me-2"></i>
              <div>
                Les champs marqués d'une * doivent être remplis.
              </div>
            </div>
            <?php if (isset($msgC1)) { ?>
              <div class="alert alert-warning d-flex align-items-center justify-content-center" role="alert">
                <i class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2"></i>
                <div><?= $msgC1; ?></div>
              </div>
            <?php } ?>
            <div class="mb-3">
              <label for="newClasse" class="form-label text-start d-block">Nouvelle classe*</label>
              <input type="text" name="newClasse" id="newClasse" class="form-control" required />
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
            <h5 class="card-title">Modifier une classe</h5>
            <div class="alert alert-primary d-flex align-items-center justify-content-center" role="alert">
              <i class="bi bi-info-circle-fill flex-shrink-0 me-2"></i>
              <div>
                Les champs marqués d'une * doivent être remplis.
              </div>
            </div>
            <?php if (isset($msgC2)) { ?>
              <div class="alert alert-warning d-flex align-items-center justify-content-center" role="alert">
                <i class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2"></i>
                <div><?= $msgC2; ?></div>
              </div>
            <?php } ?>
            <div class="mb-3">
              <label for="existingClasse" class="form-label text-start d-block">Classe existante*</label>
              <select name="existingClasse" id="existingClasse" class="form-select" required>
                <option value="">--- Sélectionner une classe ---</option>
                <?php include '../actions/functions/recupClassesAndOptions.php'; ?>
              </select>
            </div>
            <div class="mb-3">
              <label for="newClasseName" class="form-label text-start d-block">Nouveau nom de la classe*</label>
              <input type="text" name="newClasseName" id="newClasseName" class="form-control" required />
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
            <h5 class="card-title">Supprimer une classe</h5>
            <div class="alert alert-primary d-flex align-items-center justify-content-center" role="alert">
              <i class="bi bi-info-circle-fill flex-shrink-0 me-2"></i>
              <div>
                Les champs marqués d'une * doivent être remplis.
              </div>
            </div>
            <?php if (isset($msgC3)) { ?>
              <div class="alert alert-warning d-flex align-items-center justify-content-center" role="alert">
                <i class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2"></i>
                <div><?= $msgC3; ?></div>
              </div>
            <?php } ?>
            <div class="mb-3">
              <label for="existingClasse2" class="form-label text-start d-block">Classe à supprimer*</label>
              <select name="existingClasse2" id="existingClasse2" class="form-select" required>
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
