<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2024 Chromared
?>



<?php 
require '../../../actions/database.php';

// Récupération du nombre total d'utilisateurs
$requete_users = $bdd->query('SELECT COUNT(*) AS total_utilisateurs FROM users');
$resultat_users = $requete_users->fetch();
$nbCount1 = $resultat_users['total_utilisateurs'];

// Récupération du nombre total de livres
$requete_books = $bdd->query('SELECT COUNT(*) AS total_livres FROM books');
$resultat_books = $requete_books->fetch();
$nbCount2 = $resultat_books['total_livres'];

// Récupération du nombre total d'emprunts
$requete_emprunts = $bdd->query('SELECT COUNT(*) AS total_emprunts FROM emprunts');
$resultat_emprunts = $requete_emprunts->fetch();
$nbCount3 = $resultat_emprunts['total_emprunts'];

// Récupération du nombre total d'emprunts
$requete_logs = $bdd->query('SELECT COUNT(*) AS total_logs FROM log');
$resultat_logs = $requete_logs->fetch();
$nbCount4 = $resultat_logs['total_logs'];

// Debug pour vérifier si les requêtes retournent bien des résultats
if (!$resultat_users || !$resultat_books || !$resultat_emprunts || !$resultat_logs) {
    echo json_encode(['error' => 'Erreur dans la récupération des données']);
    exit();
}

// Envoyer les données en JSON
echo json_encode([
    'total_utilisateurs' => $nbCount1,
    'total_livres' => $nbCount2,
    'total_emprunts' => $nbCount3
    'total_logs' => $nbCount4
]);
?>
