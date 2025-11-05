<?php 
require '../actions/database.php';
require 'actions/users/securityAction.php';
require 'actions/users/securityAdminAction.php';
require '../actions/functions/logFunction.php';
require 'actions/others/updateDatabase.php';
require 'actions/others/addClasse.php';
require 'actions/others/updateClasse.php';
require 'actions/others/deleteClasse.php';
require 'actions/users/importUsers.php';

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
              <input type="text" name="host" id="host" class="form-control" value="<?php if(isset($host)){ echo $host; } ?>" required />
            </div>
            <div class="mb-3">
              <label for="dbname" class="form-label text-start d-block">Nom de la base de données*</label>
              <input type="text" name="dbname" id="dbname" class="form-control" value="<?php if(isset($dbname)){ echo $dbname; } ?>" placeholder="bookfind" required />
            </div>
            <div class="mb-3">
              <label for="user" class="form-label text-start d-block">Nom d'utilisateur*</label>
              <input type="text" name="user" id="user" class="form-control" value="<?php if(isset($username)){ echo $username; } ?>" required />
            </div>
            <div class="mb-3">
              <label for="password" class="form-label text-start d-block">Mot de passe</label>
              <input type="password" name="password" id="password" class="form-control" value="<?php if(isset($password)){ echo $password; }?>" />
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
  <!-- Import des utilisateurs via CSV -->
  <form method="POST" enctype="multipart/form-data" autocomplete="off">
      <div class="container mt-3">
          <div class="d-flex justify-content-center">
              <div class="card text-center mb-5" style="width: 50rem;">
                  <div class="card-body">
                      <h5 class="card-title">Importer des utilisateurs depuis un CSV</h5>
                      <div class="alert alert-primary d-flex align-items-center justify-content-center" role="alert">
                          <i class="bi bi-info-circle-fill flex-shrink-0 me-2"></i>
                          <div>
                              Choisissez un fichier CSV contenant les données utilisateurs à importer.
                          </div>
                      </div>

                      <?php if(isset($msgImport) AND !empty($msgImport)){ ?>
                          <div class="alert alert-<?= $alertImportType ?? 'warning' ?> d-flex align-items-center justify-content-center" role="alert">
                              <i class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2"></i>
                              <div><?= $msgImport; ?></div>
                          </div>
                      <?php } ?>

                      <?php if(!isset($_SESSION['csv_data'])): ?>
                          <!-- Formulaire d'upload du CSV -->
                          <div class="mb-3">
                              <label for="csvFile" class="form-label text-start d-block">Fichier CSV*</label>
                              <input type="file" name="csvFile" id="csvFile" class="form-control" accept=".csv" required />
                          </div>
                          <div class="mb-3">
                              <label for="csvSeparator" class="form-label text-start d-block">Séparateur CSV</label>
                              <select name="csvSeparator" id="csvSeparator" class="form-select">
                                  <option value=",">Virgule (,)</option>
                                  <option value=";">Point-virgule (;)</option>
                                  <option value="\t">Tabulation</option>
                                  <option value="|">Barre verticale (|)</option>
                              </select>
                          </div>
                          <div class="mb-3">
                              <label class="form-label text-start d-block">Format du fichier CSV</label>
                              <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="csvHasHeaders" id="csvHasHeaders1" value="1" checked>
                                  <label class="form-check-label" for="csvHasHeaders1">Première ligne = en-têtes (à ne pas importer)</label>
                              </div>
                              <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="csvHasHeaders" id="csvHasHeaders0" value="0">
                                  <label class="form-check-label" for="csvHasHeaders0">Première ligne = données (à importer)</label>
                              </div>
                          </div>
                          <div class="mb-3">
                              <input type="submit" name="csvUpload" class="btn btn-primary" value="Télécharger et analyser" />
                          </div>
                      <?php else: ?>
                          <div class="mb-3">
                              <h6>Correspondance des colonnes</h6>
                              <p class="small">Pour chaque champ de la base de données, sélectionnez la colonne correspondante dans votre CSV.</p>

                              <!-- Bouton pour changer de CSV -->
                              <div class="text-end mb-3">
                                  <input type="submit" name="csvCancel" class="btn btn-outline-secondary" value="Changer de fichier CSV" />
                              </div>

                              <div class="table-responsive">
                                  <table class="table table-bordered">
                                      <thead>
                                          <tr>
                                              <th colspan="2" class="bg-light">Informations de base</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                          <tr>
                                              <td><label for="map_username">Username (carte)*</label></td>
                                              <td>
                                                  <select name="db_mapping[username]" id="map_username" class="form-select" onchange="toggleCustomField('username')" required>
                                                      <option value="algorithm">Utiliser l'algorithme (première lettre prénom + nom)</option>
                                                      <option value="autre">Autre valeur...</option>
                                                      <optgroup label="Colonnes CSV">
                                                          <?php foreach($_SESSION['csv_headers'] as $index => $header): ?>
                                                          <option value="<?= $index ?>"><?= htmlspecialchars($header) ?></option>
                                                          <?php endforeach; ?>
                                                      </optgroup>
                                                  </select>
                                                  <div id="custom_username_div" class="mt-2" style="display: none;">
                                                      <input type="text" name="custom_username" id="custom_username" class="form-control" placeholder="Valeur personnalisée">
                                                  </div>
                                              </td>
                                          </tr>
                                          <tr>
                                              <td><label for="map_nom">Nom</label></td>
                                              <td>
                                                  <select name="db_mapping[nom]" id="map_nom" class="form-select" onchange="toggleCustomField('nom')">
                                                      <option value="">Non importé</option>
                                                      <option value="autre">Autre valeur...</option>
                                                      <optgroup label="Colonnes CSV">
                                                          <?php foreach($_SESSION['csv_headers'] as $index => $header): ?>
                                                          <option value="<?= $index ?>"><?= htmlspecialchars($header) ?></option>
                                                          <?php endforeach; ?>
                                                      </optgroup>
                                                  </select>
                                                  <div id="custom_nom_div" class="mt-2" style="display: none;">
                                                      <input type="text" name="custom_nom" id="custom_nom" class="form-control" placeholder="Nom">
                                                  </div>
                                              </td>
                                          </tr>
                                          <tr>
                                              <td><label for="map_prenom">Prénom</label></td>
                                              <td>
                                                  <select name="db_mapping[prenom]" id="map_prenom" class="form-select" onchange="toggleCustomField('prenom')">
                                                      <option value="">Non importé</option>
                                                      <option value="autre">Autre valeur...</option>
                                                      <optgroup label="Colonnes CSV">
                                                          <?php foreach($_SESSION['csv_headers'] as $index => $header): ?>
                                                          <option value="<?= $index ?>"><?= htmlspecialchars($header) ?></option>
                                                          <?php endforeach; ?>
                                                      </optgroup>
                                                  </select>
                                                  <div id="custom_prenom_div" class="mt-2" style="display: none;">
                                                      <input type="text" name="custom_prenom" id="custom_prenom" class="form-control" placeholder="Prénom">
                                                  </div>
                                              </td>
                                          </tr>
                                      </tbody>

                                      <thead>
                                          <tr>
                                              <th colspan="2" class="bg-light">Classe</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                          <tr>
                                              <td><label for="map_classe">Classe</label></td>
                                              <td>
                                                  <select name="db_mapping[classe]" id="map_classe" class="form-select" onchange="toggleCustomField('classe')">
                                                      <option value="">Non importé</option>
                                                      <option value="autre">Autre valeur...</option>
                                                      <optgroup label="Colonnes CSV">
                                                          <?php foreach($_SESSION['csv_headers'] as $index => $header): ?>
                                                          <option value="<?= $index ?>"><?= htmlspecialchars($header) ?></option>
                                                          <?php endforeach; ?>
                                                      </optgroup>
                                                  </select>
                                                  <div id="custom_classe_div" class="mt-2" style="display: none;">
                                                      <select name="custom_classe" id="custom_classe" class="form-select">
                                                          <option value="">--- Sélectionner une classe ---</option>
                                                          <?php
                                                          $selectClasses = $bdd->query('SELECT name FROM classes');
                                                          while($classes = $selectClasses->fetch()) {
                                                              echo '<option value="' . htmlspecialchars($classes['name']) . '">' . htmlspecialchars($classes['name']) . '</option>';
                                                          }
                                                          ?>
                                                      </select>
                                                  </div>
                                              </td>
                                          </tr>
                                      </tbody>

                                      <thead>
                                          <tr>
                                              <th colspan="2" class="bg-light">Paramètres utilisateur</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                          <tr>
                                              <td><label for="map_grade">Grade</label></td>
                                              <td>
                                                  <select name="db_mapping[grade]" id="map_grade" class="form-select">
                                                      <option value="0">Aucun (0)</option>
                                                      <option value="1">Administrateur (1)</option>
                                                      <option value="2">Gérant (2)</option>
                                                      <option value="3">Assistant (3)</option>
                                                      <optgroup label="Colonnes CSV">
                                                          <?php foreach($_SESSION['csv_headers'] as $index => $header): ?>
                                                          <option value="<?= $index ?>"><?= htmlspecialchars($header) ?></option>
                                                          <?php endforeach; ?>
                                                      </optgroup>
                                                  </select>
                                              </td>
                                          </tr>
                                          <tr>
                                              <td><label for="map_regles">Règles</label></td>
                                              <td>
                                                  <select name="db_mapping[regles]" id="map_regles" class="form-select">
                                                      <option value="0">Utiliser 0</option>
                                                      <optgroup label="Colonnes CSV">
                                                          <?php foreach($_SESSION['csv_headers'] as $index => $header): ?>
                                                          <option value="<?= $index ?>"><?= htmlspecialchars($header) ?></option>
                                                          <?php endforeach; ?>
                                                      </optgroup>
                                                  </select>
                                              </td>
                                          </tr>
                                          <tr>
                                              <td><label for="map_pdc">PDC</label></td>
                                              <td>
                                                  <select name="db_mapping[pdc]" id="map_pdc" class="form-select">
                                                      <option value="0">Utiliser 0</option>
                                                      <optgroup label="Colonnes CSV">
                                                          <?php foreach($_SESSION['csv_headers'] as $index => $header): ?>
                                                          <option value="<?= $index ?>"><?= htmlspecialchars($header) ?></option>
                                                          <?php endforeach; ?>
                                                      </optgroup>
                                                  </select>
                                              </td>
                                          </tr>
                                          <tr>
                                              <td><label for="map_nb_emprunt_max">Nombre d'emprunts max</label></td>
                                              <td>
                                                  <select name="db_mapping[nb_emprunt_max]" id="map_nb_emprunt_max" class="form-select" onchange="toggleCustomField('nb_emprunt_max')">
                                                      <option value="">Utiliser 5</option>
                                                      <option value="autre">Autre valeur...</option>
                                                      <optgroup label="Colonnes CSV">
                                                          <?php foreach($_SESSION['csv_headers'] as $index => $header): ?>
                                                          <option value="<?= $index ?>"><?= htmlspecialchars($header) ?></option>
                                                          <?php endforeach; ?>
                                                      </optgroup>
                                                  </select>
                                                  <div id="custom_nb_emprunt_max_div" class="mt-2" style="display: none;">
                                                      <input type="number" name="custom_nb_emprunt_max" id="custom_nb_emprunt_max" class="form-control" min="1" placeholder="Nombre d'emprunts maximum">
                                                  </div>
                                              </td>
                                          </tr>
                                      </tbody>

                                      <thead>
                                          <tr>
                                              <th colspan="2" class="bg-light">Authentification</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                          <tr>
                                              <td><label for="map_mdp">Mot de passe</label></td>
                                              <td>
                                                  <select name="db_mapping[mdp]" id="map_mdp" class="form-select" onchange="toggleCustomField('mdp')">
                                                      <option value="">Utiliser "ChangeMe123!"</option>
                                                      <option value="autre">Autre valeur...</option>
                                                      <optgroup label="Colonnes CSV">
                                                          <?php foreach($_SESSION['csv_headers'] as $index => $header): ?>
                                                          <option value="<?= $index ?>"><?= htmlspecialchars($header) ?></option>
                                                          <?php endforeach; ?>
                                                      </optgroup>
                                                  </select>
                                                  <div id="custom_mdp_div" class="mt-2" style="display: none;">
                                                      <input type="text" name="custom_mdp" id="custom_mdp" class="form-control" placeholder="Mot de passe">
                                                  </div>
                                              </td>
                                          </tr>
                                      </tbody>
                                  </table>
                              </div>

                              <div class="alert alert-info mt-3">
                                  <small>Aperçu : <?= count($_SESSION['csv_data']) ?> lignes sur <?= $_SESSION['total_rows'] ?> affichées.</small>
                              </div>
                          </div>
                          <div class="mb-3">
                              <input type="submit" name="csvImport" class="btn btn-success" value="Importer les utilisateurs" />
                              <input type="submit" name="csvCancel" class="btn btn-secondary ms-2" value="Annuler" />
                          </div>
                      <?php endif; ?>
                  </div>
              </div>
          </div>
      </div>
  </form>
  <script>
      function toggleCustomField(field) {
          const selectElement = document.getElementById(`map_${field}`);
          const customDiv = document.getElementById(`custom_${field}_div`);

          if (selectElement && customDiv) {
              if (selectElement.value === 'autre') {
                  customDiv.style.display = 'block';
              } else {
                  customDiv.style.display = 'none';
              }
          }
      }
  </script>
</body>
</html>