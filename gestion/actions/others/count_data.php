<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2025 Chromared
?>



<?php require '../../../actions/database.php';

// Récupération du nombre total d'utilisateurs
$requete_users = $bdd->query('SELECT COUNT(*) AS total_utilisateurs FROM users');
$resultat_users = $requete_users->fetch();
$nbCount1 = $resultat_users['total_utilisateurs'];

$requete_books = $bdd->query('SELECT COUNT(*) AS total_livres FROM books');
$resultat_books = $requete_books->fetch();
$nbCount2 = $resultat_books['total_livres'];

$requete_emprunts = $bdd->query('SELECT COUNT(*) AS total_emprunts FROM emprunts WHERE statut = 1');
$resultat_emprunts = $requete_emprunts->fetch();
$nbCount3 = $resultat_emprunts['total_emprunts'];

$requete_emprunts_retournes = $bdd->query('SELECT COUNT(*) AS total_emprunts_retournes FROM emprunts WHERE statut = 2');
$resultat_emprunts_retournes = $requete_emprunts_retournes->fetch();
$nbCount4 = $resultat_emprunts_retournes['total_emprunts_retournes'];

$requete_logs = $bdd->query('SELECT COUNT(*) AS total_logs FROM logs');
$resultat_logs = $requete_logs->fetch();
$nbCount5 = $resultat_logs['total_logs'];

if (!$resultat_users || !$resultat_books || !$resultat_emprunts || !$resultat_emprunts_retournes || !$resultat_logs) {
    echo json_encode(['error' => 'Erreur dans la récupération des données']);
    exit();
}

echo json_encode([
    'total_utilisateurs' => $nbCount1,
    'total_livres' => $nbCount2,
    'total_emprunts' => $nbCount3,
    'total_emprunts_retournes' => $nbCount4,
    'total_logs' => $nbCount5,
]);
?>
