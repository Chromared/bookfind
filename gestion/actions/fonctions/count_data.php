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

// Debug pour vérifier si les requêtes retournent bien des résultats
if (!$resultat_users || !$resultat_books) {
    echo json_encode(['error' => 'Erreur dans la récupération des données']);
    exit();
}

// Envoyer les données en JSON
echo json_encode([
    'total_utilisateurs' => $nbCount1,
    'total_livres' => $nbCount2
]);