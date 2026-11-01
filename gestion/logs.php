<?php
//This file belongs to the BookFind project.
//
//BookFind is distributed under the terms of the GNU Affero General Public License v3.0.
//
//Copyright (C) 2025 Chromared
?>

<?php require '../actions/database.php';
require '../actions/users/securityAction.php';
require 'actions/users/securityAdminAction.php';
require '../actions/functions/logFunction.php';
require 'actions/others/exportLogs.php'; ?>
<!DOCTYPE html>
<html lang="en" data-theme="<?php include '../actions/users/decodeThemeAction.php'; ?>">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BookFind — Logs</title>
  <?php include '../includes/header.php'; ?>
</head>

<body class="admin">
  <?php include 'includes/navbar.php'; ?>
  <?php if ($_SESSION['grade'] != '1') {
    http_response_code(403);
    exit();
  } ?>

  <main class="page">
    <div class="container">
      <div class="narrow stack">

        <div class="page-head">
          <div>
            <h1 class="page-head__title">Logs</h1>
            <p class="page-head__sub">Application activity log.</p>
          </div>
        </div>

        <div class="card">
          <div class="card__body">
            <div class="row">
              <div class="col" style="flex:2;min-width:200px;">
                <input id="logSearch" type="search" class="input" placeholder="Search the logs..." aria-label="Search logs">
              </div>
              <div class="col" style="flex:0 0 90px;">
                <select id="logPerPage" class="select">
                  <option value="10">10</option>
                  <option value="25">25</option>
                  <option value="50" selected>50</option>
                  <option value="100">100</option>
                </select>
              </div>
              <div class="col" style="flex:0 0 auto;">
                <label class="switch">
                  <input type="checkbox" role="switch" id="toggleAutoRefresh" checked>
                  Auto
                </label>
              </div>
            </div>
            <div class="mt-4">
              <button type="button" class="btn btn--primary" data-modal-open="exportModal">Export logs</button>
            </div>
          </div>
        </div>

        <div id="log">
          <div class="card">
            <div class="card__body center">
              <span class="spinner" aria-hidden="true"></span>
              <span class="text-subtle">Loading...</span>
            </div>
          </div>
        </div>

      </div>
    </div>
  </main>

  <div class="modal" id="exportModal">
    <div class="modal__backdrop">
      <div class="modal__dialog" role="dialog" aria-modal="true" aria-labelledby="exportModalLabel">
        <div class="modal__header">
          <h2 class="modal__title" id="exportModalLabel">GDPR Charter</h2>
          <button type="button" class="modal__close" data-modal-close aria-label="Close">
            <svg class="icon"><use href="#i-x"/></svg>
          </button>
        </div>
        <div class="modal__body">
          By exporting these logs, I acknowledge that they may contain personal data.
          I commit to comply with GDPR, in particular:
          <ul>
            <li>not to share the data without authorization,</li>
            <li>to secure them and store them temporarily,</li>
            <li>to delete them promptly if a user exercises their right to erasure.</li>
          </ul>
        </div>
        <div class="modal__footer">
          <button type="button" class="btn btn--secondary" data-modal-close>Close</button>
          <form method="post">
            <?= csrf_field(); ?>
            <input type="submit" class="btn btn--primary" name="export" value="Export to .csv format" />
          </form>
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
            console.error('Access to logs denied (HTTP ' + res.status + ')');
            document.getElementById('log').innerHTML = '<div class="alert alert--danger"><svg class="icon"><use href="#i-alert"/></svg><div>Access denied.</div></div>';
            return;
          }
          if (!res.ok) {
            console.error('Error in AJAX response');
            return;
          }
          const html = await res.text();
          document.getElementById('log').innerHTML = html;
        } catch (e) {
          console.error('AJAX network error', e);
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

      // Live search: debounce while typing
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
  <?php include '../includes/footer.php'; ?>
</body>

</html>
