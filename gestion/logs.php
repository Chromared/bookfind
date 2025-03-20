<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2024 Chromared
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
<form method="post"><p><label for="toggleAutoRefresh">Actualisation automatique</label><input type="checkbox" id="toggleAutoRefresh" checked> / <input type="submit" method="post" name="export" value="Exporter au format .csv"/></p></form>

    <div id="log"><i class="fa-duotone fa-solid fa-spinner fa-spin-pulse"></i> Chargement des logs...</div>

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