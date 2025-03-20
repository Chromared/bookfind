<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2024 Chromared
?>

<?php 
require '../actions/database.php'; 
require 'actions/users/securityAction.php';
require 'actions/users/securityAdminAction.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil de la gestion</title>
    <?php include '../includes/header.php'; ?>
</head>
<body>
    <?php include 'includes/navbar.php'; ?>
    
    <h1>Bienvenue sur la gestion du C.D.I 
        <?php if($_SESSION['grade'] == '1'){ ?> 
            et de BookFind 
        <?php } ?> !
    </h1>

    <p>
        <i title="Utilisateurs inscrits" class="fa-solid fa-user"></i> <span id="utilisateurs"><i class="fa-duotone fa-solid fa-spinner fa-spin-pulse"></i></span><br />
        <i title="Livres enregistrés" class="fa-solid fa-book"></i> <span id="livres"><i class="fa-duotone fa-solid fa-spinner fa-spin-pulse"></i></span><br />
        <i title="Emprunts en cours" class="fa-solid fa-upload"></i> <span id="emprunts"><i class="fa-duotone fa-solid fa-spinner fa-spin-pulse"></i></span><br />
        <i title="Emprunts retournés" class="fa-solid fa-download"></i> <span id="emprunts_retournes"><i class="fa-duotone fa-solid fa-spinner fa-spin-pulse"></i></span><br />
        <?php if($_SESSION['grade'] == 1){ ?><i title="Logs" class="fa-solid fa-newspaper"></i> <span id="log"><i class="fa-duotone fa-solid fa-spinner fa-spin-pulse"></i></span><br /><?php } ?>
    </p>

    <script>
    function updateCounters() {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'actions/others/count_data.php', true);
        xhr.onload = function() {
            if (xhr.status == 200) {
                var data = JSON.parse(xhr.responseText);
                document.getElementById('utilisateurs').textContent = data.total_utilisateurs;
                document.getElementById('livres').textContent = data.total_livres;
                document.getElementById('emprunts').textContent = data.total_emprunts;
                document.getElementById('emprunts_retournes').textContent = data.total_emprunts_retournes;
                <?php if($_SESSION['grade'] == 1){ ?>document.getElementById('log').textContent = data.total_logs;<?php } ?>
            } else {
                console.error('Erreur dans la réponse AJAX');
            }
        };
        xhr.onerror = function() {
            console.error('Erreur réseau AJAX');
        };
        xhr.send();
    }

    updateCounters();

    setInterval(updateCounters, 1000);
    </script>
</body>
</html>