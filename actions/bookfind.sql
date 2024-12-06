-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 06 déc. 2024 à 18:16
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `bookfind`
--

-- --------------------------------------------------------

--
-- Structure de la table `authors`
--

CREATE TABLE `authors` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `nomprenom` varchar(255) NOT NULL,
  `biographie` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `authors`
--

INSERT INTO `authors` (`id`, `nom`, `prenom`, `nomprenom`, `biographie`) VALUES
(3, 'Riordans', 'Rick', 'Riordans, Rick', 'Auteur de Percy Jackson'),
(4, 'Laucoin', 'Joachim', 'Laucoin, Joachim', NULL),
(5, 'Gaudron', 'Thomas', 'Gaudron, Thomas', 'Il est cool.'),
(6, 'Muller', 'Alban', 'Muller, Alban', 'Il est développeur de Bookfind. Il est génial !');

-- --------------------------------------------------------

--
-- Structure de la table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `auteur` varchar(255) NOT NULL,
  `isbn` int(255) NOT NULL,
  `id_unique` varchar(255) DEFAULT NULL,
  `resume` text DEFAULT NULL,
  `editeur` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `serie` varchar(255) DEFAULT NULL,
  `tome` int(11) DEFAULT NULL,
  `statut` int(11) NOT NULL,
  `genre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `books`
--

INSERT INTO `books` (`id`, `titre`, `auteur`, `isbn`, `id_unique`, `resume`, `editeur`, `type`, `serie`, `tome`, `statut`, `genre`) VALUES
(1, 'Alban', 'Muller, Alban', 123, '', '', 'WIZ', 'Manuel scolaire', '', 0, 2, '');

-- --------------------------------------------------------

--
-- Structure de la table `editeurs`
--

CREATE TABLE `editeurs` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `editeurs`
--

INSERT INTO `editeurs` (`id`, `nom`) VALUES
(1, 'WIZ'),
(2, 'Albin Michel');

-- --------------------------------------------------------

--
-- Structure de la table `emprunts`
--

CREATE TABLE `emprunts` (
  `id` int(11) NOT NULL,
  `id_book` int(11) NOT NULL,
  `titre_book` varchar(255) NOT NULL,
  `date_emprunt` datetime NOT NULL DEFAULT current_timestamp(),
  `date_futur_retour` date NOT NULL,
  `date_retour` datetime DEFAULT NULL,
  `card_emprunteur` int(11) NOT NULL,
  `firstname_name` varchar(255) NOT NULL,
  `statut` int(3) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `genres`
--

CREATE TABLE `genres` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `genres`
--

INSERT INTO `genres` (`id`, `nom`) VALUES
(1, 'Horreur'),
(2, 'Humour'),
(3, 'Fantasy'),
(4, 'Fantastique');

-- --------------------------------------------------------

--
-- Structure de la table `log`
--

CREATE TABLE `log` (
  `id` int(11) NOT NULL,
  `page` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_card` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `comment` text NOT NULL,
  `datetime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `log`
--

INSERT INTO `log` (`id`, `page`, `user_id`, `user_card`, `user_name`, `type`, `comment`, `datetime`) VALUES
(1, '/bookfind/login.php', 1, 89702661, 'Alban Muller', 'Connexion', 'Aucun', '2024-11-28 17:45:32'),
(2, '/bookfind/gestion/update-user.php?id=51', 1, 89702661, 'Alban Muller', 'Modification de grade', 'Le grade de 2 2 (2) à été changé de  vers .', '2024-11-28 17:46:30'),
(3, '/bookfind/gestion/update-user.php?id=51', 1, 89702661, 'Alban Muller', 'Modification de grade', 'Le grade de 2 2 (2) à été changé de Assistant vers Gérant.', '2024-11-28 17:50:17'),
(4, '/bookfind/actions/users/logoutAction.php', 1, 89702661, 'Alban Muller', 'Déconnexion', 'Aucun', '2024-11-28 18:00:15'),
(5, '/bookfind/login.php', 51, 2, '2 2', 'Connexion', 'Aucun', '2024-11-28 18:00:17'),
(6, '/bookfind/gestion/update-user.php?id=50', 51, 2, '2 2', 'Modification de mot de passe', 'Le mot de passe de 1 1 (1) à été changé.', '2024-11-28 18:40:37'),
(7, '/BookFind/login.php', 1, 89702661, 'Alban Muller', 'Connexion', 'Aucun', '2024-12-04 18:15:05'),
(8, '/BookFind/login.php', 1, 89702661, 'Alban Muller', 'Connexion', 'Aucun', '2024-12-05 18:00:27'),
(9, '/BookFind/login.php', 1, 89702661, 'Alban Muller', 'Connexion', 'Aucun', '2024-12-05 18:03:39'),
(10, '/bookfind/login.php', 1, 89702661, 'Alban Muller', 'Connexion', 'Aucun', '2024-12-06 17:51:16');

-- --------------------------------------------------------

--
-- Structure de la table `types`
--

CREATE TABLE `types` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `types`
--

INSERT INTO `types` (`id`, `nom`) VALUES
(1, 'Manuel scolaire'),
(2, 'Bande dessinées'),
(4, 'Roman'),
(5, 'Manga');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(255) NOT NULL,
  `carte` int(8) NOT NULL,
  `classe` varchar(2) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(25) NOT NULL,
  `mdp` text NOT NULL,
  `grade` int(1) NOT NULL DEFAULT 0,
  `datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `regles` int(1) NOT NULL,
  `pdc` int(1) NOT NULL,
  `nb_emprunt_max` int(255) NOT NULL DEFAULT 5,
  `nb_emprunt` int(255) NOT NULL DEFAULT 0,
  `theme` int(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `carte`, `classe`, `nom`, `prenom`, `mdp`, `grade`, `datetime`, `regles`, `pdc`, `nb_emprunt_max`, `nb_emprunt`, `theme`) VALUES
(1, 89702661, '3B', 'Muller', 'Alban', 'youWantMyPassword?', 1, '2024-09-27 17:35:04', 1, 1, 5, -1, 0),
(50, 1, '6B', '1', '1', '2y.e123ltUAK.', 3, '2024-11-27 18:06:40', 1, 1, 5, 0, 0),
(51, 2, '6B', '2', '2', '2yXTT36samgcE', 2, '2024-11-27 18:07:13', 1, 1, 5, 0, 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `authors`
--
ALTER TABLE `authors`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_unique` (`id_unique`);

--
-- Index pour la table `editeurs`
--
ALTER TABLE `editeurs`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `emprunts`
--
ALTER TABLE `emprunts`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `types`
--
ALTER TABLE `types`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `carte` (`carte`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `authors`
--
ALTER TABLE `authors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `editeurs`
--
ALTER TABLE `editeurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `emprunts`
--
ALTER TABLE `emprunts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `genres`
--
ALTER TABLE `genres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `log`
--
ALTER TABLE `log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `types`
--
ALTER TABLE `types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
