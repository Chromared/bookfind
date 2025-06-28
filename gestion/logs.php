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
    require '../actions/functions/logFunction.php';
    require 'actions/others/exportLogs.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logs</title>
    <?php include '../includes/header.php'; ?>
</head>
<body>
<?php include 'includes/navbar.php'; ?>
<br />
<?php if($_SESSION['grade'] !== 1){ die('Vous n\'avez pas les permissions d\'administrateur et elles sont nécessaire pour accéder à cette page.'); } ?>

<div class="container mt-3">
  <div class="d-flex justify-content-center mt-4">
    <div class="card text-center mb-3" style="width: 50rem;">
      <div class="card-body">
        <h5 class="card-title">Logs</h5>
        <h6 class="card-subtitle mb-2 text-body-secondary">Paramètres</h6>
        <p class="card-text">
          <div class="mb-3">
            <div class="form-check form-switch d-flex justify-content-center">
              <input type="checkbox" class="form-check-input" role="switch" id="toggleAutoRefresh" checked>
              <label class="form-check-label" for="toggleAutoRefresh">
                Actualisation automatique
              </label>
            </div>
          </div>
          <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exportModal">
            Exporter les logs
          </button>
          <div class="modal fade" id="exportModal" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5">Charte RGPD</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-start">
                  En exportant ces logs, je reconnais qu’ils peuvent contenir des données personnelles.  
                  Je m’engage à respecter la réglementation RGPD, notamment :  
                  <ul class="text-start mt-2">
                    <li>à ne pas diffuser les données sans autorisation,</li>
                    <li>à les sécuriser et les conserver de manière temporaire,</li>
                    <li>à les supprimer sans délai si un utilisateur exerce son droit d’effacement.</li>
                  </ul>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                  <form method="post">
                    <input type="submit" class="btn btn-primary" name="export" value="Exporter au format .csv"/>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </p>
      </div>
    </div>
  </div>
</div>
<div id="log">
    <div class="container mt-3">
      <div class="d-flex justify-content-center mt-4">
        <div class="card text-center mb-3" style="width: 50rem;">
          <div class="card-body">
            <button class="btn btn-primary" type="button" disabled>
              <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
              <span role="status">Chargement...</span>
            </button>
          </div>
        </div>
      </div>
    </div>

    <script>
        function load_logs() {
            $('#log').load('actions/others/loadLogs.php');
        }

        let intervalID;

        function startAutoRefresh() {
            if (!intervalID) {
                intervalID = setInterval(load_logs, 1000);
            }
        }

        function stopAutoRefresh() {
            clearInterval(intervalID);
            intervalID = null;
            load_logs(); // Charge une dernière fois les logs avant d'arrêter
        }

        // Gestion de la case à cocher
        $('#toggleAutoRefresh').on('change', function () {
            if (this.checked) {
                startAutoRefresh();
            } else {
                stopAutoRefresh();
            }
        });

        // Lancer l'actualisation automatique au chargement de la page
        startAutoRefresh();
    </script>
</body>
</html>