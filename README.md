# BookFind

BookFind est une application web permettant aux utilisateurs d'un Centre de Documentation et d'Information (CDI) de rechercher et d'emprunter des livres.

## Fonctionnalités

- **Page d'accueil** : Accès à une vue d'ensemble de l'application et options de recherche de livres.
- **Recherche de livres** : Permet de trouver des livres disponibles au CDI et d'afficher leurs informations détaillées.
- **Gestion des emprunts** : Les utilisateurs peuvent consulter leurs emprunts et l’historique.
- **Connexion et gestion de profil** : Authentification sécurisée pour accéder aux fonctionnalités réservées.

## Installation

1. Cloner ce dépôt ou télécharger le fichier ZIP du projet.
2. Assurez-vous d'avoir un serveur local (ex : XAMPP, WAMP) avec PHP et MySQL.
3. Placez le dossier du projet dans le répertoire racine de votre serveur web (ex : `htdocs` pour XAMPP).
4. Importez le fichier SQL fourni dans votre base de données pour initialiser les tables nécessaires.

## Configuration de la Base de Données

1. Accédez au fichier de configuration de la base de données (`actions/database.php`).
2. Modifiez les informations de connexion à la base de données pour correspondre à votre environnement (nom d'utilisateur, mot de passe, nom de la base de données).

## Utilisation

- **Page d'accueil** : Affiche une introduction et un formulaire de recherche de livres.
- **Connexion** : Accédez à `login.php` pour vous connecter. Les utilisateurs non connectés n'ont pas accès à certaines fonctionnalités.
- **Recherche de livres** : Dans `books.php`, vous pouvez rechercher des livres par titre, auteur, etc.
- **Profil** : Consultez et modifiez les informations du profil.

## Dépendances

- **PHP** : version 7.4 ou supérieure.
- **MySQL** : Pour la gestion de la base de données.
- **Serveur Web** : Apache ou équivalent pour héberger l'application.

## Licence

Ce projet est sous licence X11, Copyright © 2024 Chromared.
