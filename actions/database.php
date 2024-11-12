<?php
//This file belongs to the Bookfind project.
//
//Bookfind is distributed under the terms of the MIT software license.
//
//Copyright (C) 2024 Chromared
?>



<?php
// Informations de connexion
$host = 'localhost'; // Remplacez par l'adresse de votre serveur
$dbname = 'bookfind'; // Remplacez par le nom de votre base de données
$username = 'root'; // Remplacez par votre nom d'utilisateur
$password = ''; // Remplacez par votre mot de passe

try {
    // Création de la connexion avec PDO
    $bdd = new PDO('mysql:host=' . $host . ';dbname=' . $dbname . ';charset=utf8', $username, $password);
    // Configuration pour afficher les erreurs (utile en développement)
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Gestion de l'erreur
    echo 'Connexion failed : ' . $e->getMessage();
}
?>
