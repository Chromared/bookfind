<?php 
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2025 Chromared
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
    <style>
        .card-widget i {
            font-size: 2rem;
        }
        .card-widget .card-body {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
    </style>
</head>
<body>
    <?php include 'includes/navbar.php'; ?>

    <div class="container mt-5">
        <h1 class="text-center mb-4">
            Gestion du C.D.I 
            <?php if($_SESSION['grade'] == '1'){ ?> 
                et de BookFind 
            <?php } ?>
        </h1>

        <div class="row g-4">

            <!-- Utilisateurs -->
            <div class="col-md-6 col-lg-4">
                <div class="card text-white bg-primary card-widget">
                    <div class="card-body">
                        <div><i class="bi bi-people" title="Utilisateurs inscrits"></i></div>
                        <div id="utilisateurs">
                            <div class="spinner-border text-light" role="status" style="width: 1.5rem; height: 1.5rem;">
                                <span class="visually-hidden">Chargement...</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center">Utilisateurs inscrits</div>
                </div>
            </div>

            <!-- Livres -->
            <div class="col-md-6 col-lg-4">
                <div class="card text-white bg-success card-widget">
                    <div class="card-body">
                        <div><i class="bi bi-journal-bookmark-fill" title="Livres enregistrés"></i></div>
                        <div id="livres">
                            <div class="spinner-border text-light" role="status" style="width: 1.5rem; height: 1.5rem;">
                                <span class="visually-hidden">Chargement...</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center">Livres enregistrés</div>
                </div>
            </div>

            <!-- Emprunts en cours -->
            <div class="col-md-6 col-lg-4">
                <div class="card text-white bg-warning card-widget">
                    <div class="card-body">
                        <div><i class="bi bi-journal-arrow-up" title="Emprunts en cours"></i></div>
                        <div id="emprunts">
                            <div class="spinner-border text-light" role="status" style="width: 1.5rem; height: 1.5rem;">
                                <span class="visually-hidden">Chargement...</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center">Emprunts en cours</div>
                </div>
            </div>

            <!-- Emprunts retournés -->
            <div class="col-md-6 col-lg-4">
                <div class="card text-white bg-info card-widget">
                    <div class="card-body">
                        <div><i class="bi bi-journal-arrow-down" title="Emprunts retournés"></i></div>
                        <div id="emprunts_retournes">
                            <div class="spinner-border text-light" role="status" style="width: 1.5rem; height: 1.5rem;">
                                <span class="visually-hidden">Chargement...</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center">Emprunts retournés</div>
                </div>
            </div>

            <!-- Logs (admin uniquement) -->
            <?php if($_SESSION['grade'] == 1){ ?>
            <div class="col-md-6 col-lg-4">
                <div class="card text-white bg-secondary card-widget">
                    <div class="card-body">
                        <div><i class="bi bi-newspaper" title="Logs"></i></div>
                        <div id="log">
                            <div class="spinner-border text-light" role="status" style="width: 1.5rem; height: 1.5rem;">
                                <span class="visually-hidden">Chargement...</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center">Logs</div>
                </div>
            </div>
            <?php } ?>

        </div>
    </div>

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
<br />
</body>
</html>
