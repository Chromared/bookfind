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
- D'accéder aux fonctionnalités protégées àils sont gradés

Cette application offre une solution efficace pour le personnel du CDI et leurs utilisateurs.

## Fonctionnalités

- **Page d'accueil** : Présentation de l'application et formulaire de recherche de livres.
- **Recherche de livres** : Interface permettant aux utilisateurs de trouver des livres en fonction de leur titre
- **Gestion des emprunts** : Permet de voir les livres empruntés et l'historique d'emprunt.
- **Connexion et profil utilisateur** : Authentification avec mot de passe crypté, accès aux fonctionnalités réservées, ainsi qu'un espace pour gérer son profil ou modifier le profil d'un utilisateur si on est gradé. Les parties modifiables varient en fonction du niveau de permission.

## Structure du Projet

- `index.php` : Page principale de l'application, introduisant le service de recherche de livres.
- `login.php` : Page de connexion pour authentifier les utilisateurs.
- `books.php` : Page de recherche de livres avec un formulaire pour entrer des critères de recherche.
- `profil.php` : Interface permettant aux utilisateurs de consulter et de modifier leurs informations personnelles.
- `emprunts.php` : Page où l'utilisateur peut voir les livres qu'il a empruntés.
- `pdc.php` : Page affichant les politiques de confidentialité et les conditions d'utilisation.
- `rules.php` : Page affichant le règlement.

### Répertoires

- `actions/` : Contient les scripts PHP et JavaScript pour les actions, comme la connexion à la base de données, l´enregistrement d'un livre et le fonctionnement du site en général.
- `includes/` : Composants inclus dans les différentes pages, comme le `header.php` et la `navbar.php` pour un affichage cohérent. Ce dossier sert à centraliser des bouts de code qui n'auront pas à être répétés et où le changement impacteront toutes les pages.
- `style/` : Ressources telles que les fichiers CSS, images et icones.

## Installation

1. **Cloner le dépôt ou télécharger le ZIP** :
    ```bash
    git clone https://github.com/chromared/bookfind.git
    ```
2. **Configuration du serveur local** :
    - Utilisez XAMPP, WAMP, ou un autre serveur avec PHP et MySQL.
3. **Déplacer le projet** :
    - Placez le dossier extrait dans le répertoire racine de votre serveur web (en général `htdocs` sur les serveurs web et XAMPP ou `www` pour WAMP et uWAMP).

## Configuration

1. Dans votre navigateur, rendez-vous sur le fichier `configuration.php`.
2. Suivez les actions **dans l'ordre** pour configurer la base de donnée, les classes de votre établissement...
3. Quand vous avez fini, cliquez sur le bouton qui est apparu permettant de supprimer le fichier `configuration.php` car il ne sera plus d'aucune utilité et que, sachant qu'aucune restriction n'est appliquée, il serait dangereux de le laisser.

## Utilisation

### Étapes d'utilisation de l'application

1. **Accéder à la Page d'accueil** : Rendez-vous sur `index.php` pour une vue d'ensemble et un accès rapide à la recherche de livres.
2. **Créer un compte et se connecter** :
    - Allez sur `signup.php` ou `login.php` pour créer un compte ou vous connecter.
3. **Rechercher des livres** :
    - Utilisez `books.php` pour explorer les livres disponibles.
4. **Voir et gérer le profil** :
    - Consultez et modifiez vos informations personnelles sur `profil.php`.
5. **Suivre les emprunts** :
    - Rendez-vous sur `emprunts.php` pour consulter vos livres empruntés et leur statut.
6. **Gestion** :
    - Pour les gradés, un lien "Gestion" apparaît dans la barre de navigation. En fonction de vos permissions, ce lien vous permettera d'accéder à certaines options de configuration du site ou du C.D.I.

## Environnement

- **Serveur Web** : Apache
- **PHP** : version 7.4 ou supérieure.
- **MySQL** : Pour la gestion de la base de données. MySQL et MariaDB sont utilisés par notre équipe lors du développement.

## Dépendances

- **Aucune** : Il n'y a pour l'instant pas de dépendances nécessaires au fonctionnement de BookFind.

## Licence

Ce projet est distribué selon les termes de la license [MIT]. 2025 Chromared.

---

[MIT]: https://opensource.org/licenses/MIT

