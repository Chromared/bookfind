<?php 
require '../actions/database.php'; 
require '../actions/users/securityAction.php';
require 'actions/securityActionAdmin.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include '../includes/header.php'; ?>
</head>
<body>
    <?php include 'includes/navbar.php'; ?>
    
    <h1>Bienvenue sur la gestion du C.D.I 
        <?php if($_SESSION['grade'] == '1'){ ?> 
            et de BookFind 
        <?php } else { 
            echo htmlspecialchars(''); 
        } ?> !
    </h1>

    <p>
        <i class="fa-solid fa-user"></i> <span id="utilisateurs">Chargement...</span><br>
        <i class="fa-solid fa-book"></i> <span id="livres">Chargement...</span><br>
    </p>

    <script>
    // Fonction pour récupérer les données avec AJAX et mettre à jour les compteurs
    function updateCounters() {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'actions/fonctions/count_data.php', true);
        xhr.onload = function() {
            console.log('Requête envoyée, statut:', xhr.status); // Debug
            if (xhr.status == 200) {
                console.log('Réponse reçue:', xhr.responseText); // Debug
                var data = JSON.parse(xhr.responseText);
                document.getElementById('utilisateurs').textContent = data.total_utilisateurs;
                document.getElementById('livres').textContent = data.total_livres;
            } else {
                console.error('Erreur dans la réponse AJAX');
            }
        };
        xhr.onerror = function() {
            console.error('Erreur réseau AJAX');
        };
        xhr.send();
    }

    // Mettre à jour les compteurs immédiatement
    updateCounters();

    // Mettre à jour les compteurs toutes les secondes
    setInterval(updateCounters, 1000);
    </script>
</body>
</html>