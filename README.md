# BookFind

**BookFind** est une application web destinée aux utilisateurs d'un Centre de Documentation et d'Information (CDI). Elle permet la recherche et l'emprunt de livres via une interface intuitive et une gestion sécurisée des utilisateurs.

---

## Table des matières

1. [Aperçu du Projet](#aperçu-du-projet)
2. [Fonctionnalités](#fonctionnalités)
3. [Structure du Projet](#structure-du-projet)
4. [Installation](#installation)
5. [Configuration de la Base de Données](#configuration-de-la-base-de-données)
6. [Utilisation](#utilisation)
7. [Dépendances](#dépendances)
8. [Licence](#licence)

---

## Aperçu du Projet

Le projet **BookFind** est conçu pour simplifier la gestion des emprunts de livres au sein d’un CDI. L’application permet aux utilisateurs :
- De rechercher des ouvrages disponibles
- D'emprunter des livres
- De consulter leurs emprunts en cours
- De se connecter pour accéder aux fonctionnalités protégées.

Cette application offre une solution efficace pour le personnel du CDI et les utilisateurs.

## Fonctionnalités

- **Page d'accueil** : Présentation de l'application et formulaire de recherche de livres.
- **Recherche de livres** : Interface permettant aux utilisateurs de trouver des livres en fonction de critères spécifiques (titre, auteur, etc.).
- **Gestion des emprunts** : Permet de voir les livres empruntés et l'historique d'emprunt.
- **Connexion et profil utilisateur** : Authentification sécurisée avec accès aux fonctionnalités réservées, ainsi qu'un espace pour gérer le profil.

## Structure du Projet

- `index.php` : Page principale de l'application, introduisant le service de recherche de livres.
- `login.php` : Page de connexion pour authentifier les utilisateurs.
- `books.php` : Page de recherche de livres avec un formulaire pour entrer des critères de recherche.
- `profil.php` : Interface permettant aux utilisateurs de consulter et de modifier leurs informations personnelles.
- `emprunts.php` : Page où l'utilisateur peut voir les livres qu'il a empruntés.
- `pdc.php` : Page affichant les politiques de confidentialité et les conditions d'utilisation.

### Répertoires

- `actions/` : Contient les scripts PHP pour les actions de gestion, comme la connexion à la base de données, et les fonctions associées.
  - `database.php` : Configuration et connexion à la base de données.
  - `users/loginAction.php` : Gestion des actions de connexion des utilisateurs.
- `includes/` : Composants inclus dans les différentes pages, comme le `header` et la `navbar` pour un affichage cohérent.
- `assets/` : Ressources telles que les fichiers CSS et JavaScript (à ajouter selon les besoins).

## Installation

1. **Cloner le dépôt ou télécharger le ZIP** :
    ```bash
    git clone https://github.com/chromared/bookfind.git
    ```
2. **Configuration du serveur local** :
    - Utilisez XAMPP, WAMP, ou un autre serveur avec PHP et MySQL.
3. **Déplacer le projet** :
    - Placez le dossier extrait dans le répertoire racine de votre serveur web (ex : `htdocs` pour XAMPP).
4. **Importer la base de données** :
    - Dans votre interface MySQL (comme phpMyAdmin), créez une base de données et importez-y le fichier SQL fourni pour créer les tables nécessaires.

## Configuration de la Base de Données

1. Ouvrez le fichier `actions/database.php`.
2. Remplacez les valeurs par celles de votre environnement:
    ```php
    $host = 'localhost';
    $dbname = 'nom_de_votre_base';
    $username = 'nom_utilisateur';
    $password = 'mot_de_passe';
    ```
3. Enregistrez les modifications.

## Utilisation

### Étapes d'utilisation de l'application

1. **Accéder à la Page d'accueil** : Rendez-vous sur `index.php` pour une vue d'ensemble et un accès rapide à la recherche de livres.
2. **Créer un compte et se connecter** :
    - Allez sur `login.php` pour créer un compte ou vous connecter.
3. **Rechercher des livres** :
    - Utilisez `books.php` pour explorer les livres disponibles.
4. **Voir et gérer le profil** :
    - Consultez et modifiez vos informations personnelles sur `profil.php`.
5. **Suivre les emprunts** :
    - Rendez-vous sur `emprunts.php` pour consulter vos livres empruntés et leur statut.

## Dépendances

- **PHP** : version 7.4 ou supérieure.
- **SQL** : Pour la gestion de la base de données, MariaDB est fortement recommandée.
- **Serveur Web** : Apache

## Licence

Ce projet est distribué selon les termes de la license [MIT]. 2024 Chromared.

---

[MIT]: https://opensource.org/licenses/MIT

