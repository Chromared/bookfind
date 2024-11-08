# X11 License
# 2024 Chromared


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
    <title>Accueil de la gestion</title>
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
        <i class="fa-solid fa-user"></i> <span id="utilisateurs"><i class="fa-duotone fa-solid fa-spinner fa-spin-pulse"></i></span><br>
        <i class="fa-solid fa-book"></i> <span id="livres"><i class="fa-duotone fa-solid fa-spinner fa-spin-pulse"></i></span><br>
        <i class="fa-solid fa-upload"></i> <span id="emprunts"><i class="fa-duotone fa-solid fa-spinner fa-spin-pulse"></i></span><br>
    </p>

    <script>
    // Fonction pour récupérer les données avec AJAX et mettre à jour les compteurs
    function updateCounters() {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'actions/fonctions/count_data.php', true);
        xhr.onload = function() {
            if (xhr.status == 200) {
                var data = JSON.parse(xhr.responseText);
                document.getElementById('utilisateurs').textContent = data.total_utilisateurs;
                document.getElementById('livres').textContent = data.total_livres;
                document.getElementById('emprunts').textContent = data.total_emprunts;
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