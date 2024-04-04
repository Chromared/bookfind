-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 04 avr. 2024 à 17:54
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.2.4

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
-- Structure de la table `auteurs`
--

CREATE TABLE `auteurs` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `biographie` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `auteur` varchar(255) NOT NULL,
  `isbn` int(255) NOT NULL,
  `resume` text DEFAULT NULL,
  `editeur` varchar(255) NOT NULL,
  `serie` varchar(255) DEFAULT NULL,
  `tome` int(11) DEFAULT NULL,
  `nb_exemplaires` int(11) NOT NULL,
  `statut` int(11) NOT NULL,
  `genre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `emprunts`
--

CREATE TABLE `emprunts` (
  `id` int(11) NOT NULL,
  `id_livre` int(11) NOT NULL,
  `date_emprunt` varchar(10) NOT NULL,
  `date_retour` varchar(10) NOT NULL,
  `id_emprunteur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `genres`
--

CREATE TABLE `genres` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `date_j_lettre` varchar(255) NOT NULL,
  `date_j` varchar(2) NOT NULL,
  `date_m` varchar(2) NOT NULL,
  `date_a` varchar(4) NOT NULL,
  `heure_h` varchar(2) NOT NULL,
  `heure_m` varchar(2) NOT NULL,
  `heure_s` varchar(2) NOT NULL,
  `regles` int(1) NOT NULL,
  `pdc` int(1) NOT NULL,
  `nb_emprunt_max` int(255) NOT NULL DEFAULT 5,
  `nb_emprunt` int(255) NOT NULL DEFAULT 0,
  `theme` int(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `carte`, `classe`, `nom`, `prenom`, `mdp`, `grade`, `date_j_lettre`, `date_j`, `date_m`, `date_a`, `heure_h`, `heure_m`, `heure_s`, `regles`, `pdc`, `nb_emprunt_max`, `nb_emprunt`, `theme`) VALUES
(1, 89702661, '4B', 'Muller', 'Alban', '2yrir8P1qFkn.', 1, 'Tuesday', '26', '03', '24', '18', '19', '05', 1, 1, 5, 4, 0),
(41, 5, '6F', 'Alban', 'Muller', '2yOSnUkA4y91Y', 2, 'Monday', '01', '01', '0001', '01', '01', '01', 1, 1, 5, 0, 0),
(42, 1, '6B', 'Y', 'X', '2yOSnUkA4y91Y', 3, 'Tuesday', '26', '03', '24', '18', '37', '44', 1, 1, 5, 2, 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `auteurs`
--
ALTER TABLE `auteurs`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `books`
--
ALTER TABLE `books`
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
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `auteurs`
--
ALTER TABLE `auteurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `emprunts`
--
ALTER TABLE `emprunts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `genres`
--
ALTER TABLE `genres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
