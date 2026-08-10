<?php
//This file belongs to the BookFind project.
//
//BookFind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2025 Chromared
?>

<?php require '../actions/database.php';
require '../actions/users/securityAction.php';
require 'actions/users/securityAdminAction.php';
require '../actions/functions/logFunction.php';
require 'actions/others/exportLogs.php'; ?>
<!DOCTYPE html>
<html lang="fr" data-bs-theme="<?php include '../actions/users/decodeThemeAction.php'; ?>">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Logs</title>
  <?php include '../includes/header.php'; ?>
</head>

<body class="d-flex flex-column min-vh-100">
  <?php include 'includes/navbar.php'; ?>
  <br />
  <?php if ($_SESSION['grade'] != '1') {
    http_response_code(403);
    exit();
  } ?>

  <div class="container mt-3">
    <div class="d-flex justify-content-center mt-4">
      <div class="card text-center mb-3" style="width: 50rem;">
        <div class="card-body">
          <h5 class="card-title">Logs</h5>
          <h6 class="card-subtitle mb-2 text-body-secondary">Paramètres</h6>
          <p class="card-text">
          <div class="mb-3">
            <div class="row g-2 align-items-center">
              <div class="col-6">
                <div class="input-group">
                  <input id="logSearch" type="search" class="form-control" placeholder="Rechercher dans les logs..." aria-label="Recherche logs">
                </div>
              </div>
              <div class="col-3">
                <select id="logPerPage" class="form-select">
                  <option value="10">10</option>
                  <option value="25">25</option>
                  <option value="50" selected>50</option>
                  <option value="100">100</option>
                </select>
              </div>
              <div class="col-3 d-flex justify-content-end">
                <div class="form-check form-switch d-flex justify-content-center align-items-center gap-1">
                  <input type="checkbox" class="form-check-input" role="switch" id="toggleAutoRefresh" checked>
                  <label class="form-check-label ms-1" for="toggleAutoRefresh">Auto</label>
                </div>
              </div>
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
                    <?= csrf_field(); ?>
                    <input type="submit" class="btn btn-primary" name="export" value="Exporter au format .csv" />
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

    <script nonce="<?= htmlspecialchars($_SESSION['csp_nonce'] ?? '') ?>">
      document.addEventListener('DOMContentLoaded', function() {
        let currentPage = 1;
        let perPage = parseInt(document.getElementById('logPerPage').value, 10) || 50;
        let query = '';
        let showAll = false;
        let intervalID = null;

        async function loadLogs() {
          const params = new URLSearchParams();
          params.set('page', currentPage);
          params.set('per_page', perPage);
          if (showAll) params.set('show_all', '1');
          if (query) params.set('q', query);

          try {
            const res = await fetch('actions/others/loadLogs.php?' + params.toString(), { credentials: 'same-origin' });
            if (res.status === 401 || res.status === 403) {
              console.error('Accès refusé aux logs (HTTP ' + res.status + ')');
              document.getElementById('log').innerHTML = '<div class="alert alert-danger">Accès refusé.</div>';
              return;
            }
            if (!res.ok) {
              console.error('Erreur dans la réponse AJAX');
              return;
            }
            const html = await res.text();
            document.getElementById('log').innerHTML = html;
          } catch (e) {
            console.error('Erreur réseau AJAX', e);
          }
        }

        function startAutoRefresh() {
          if (!intervalID) {
            intervalID = setInterval(loadLogs, 5000);
          }
        }

        function stopAutoRefresh() {
          if (intervalID) {
            clearInterval(intervalID);
            intervalID = null;
          }
        }

        // Events
        document.getElementById('logPerPage').addEventListener('change', function() {
          perPage = parseInt(this.value, 10) || 50;
          currentPage = 1;
          showAll = false;
          loadLogs();
        });

        // Recherche live : debounce pendant la saisie
        (function() {
          const input = document.getElementById('logSearch');
          let timer = null;
          input.addEventListener('input', function() {
            clearTimeout(timer);
            timer = setTimeout(function() {
              query = input.value.trim();
              currentPage = 1;
              showAll = false;
              loadLogs();
            }, 300);
          });
        })();

        // Delegate pagination and showall buttons inside #log
        document.getElementById('log').addEventListener('click', function(ev) {
          const t = ev.target;
          if (t.closest && t.closest('.log-page-btn')) {
            const btn = t.closest('.log-page-btn');
            const p = parseInt(btn.getAttribute('data-page'), 10) || 1;
            currentPage = p;
            loadLogs();
          } else if (t.closest && t.closest('.log-showall-btn')) {
            const btn = t.closest('.log-showall-btn');
            const sa = btn.getAttribute('data-showall');
            showAll = sa === '1' || sa === 'true';
            currentPage = 1;
            loadLogs();
          }
        });

        // Auto-refresh switch
        document.getElementById('toggleAutoRefresh').addEventListener('change', function() {
          if (this.checked) startAutoRefresh(); else stopAutoRefresh();
        });

        // Initial load
        loadLogs();
        startAutoRefresh();
      });
    </script>
  </div>
  <?php include '../includes/footer.php'; ?>
</body>

</html>