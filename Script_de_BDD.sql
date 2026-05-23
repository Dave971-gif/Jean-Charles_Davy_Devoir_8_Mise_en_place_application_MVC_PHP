-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 22 mai 2026 à 18:07
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
-- Base de données : `jeu_essai`
--
CREATE DATABASE IF NOT EXISTS `jeu_essai` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `jeu_essai`;

-- --------------------------------------------------------

--
-- Structure de la table `agencies`
--

CREATE TABLE `agencies` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `agencies`
--

INSERT INTO `agencies` (`id`, `nom`) VALUES
(1, 'Paris'),
(2, 'Lyon'),
(3, 'Marseille'),
(4, 'Toulouse'),
(5, 'Nice'),
(6, 'Nantes'),
(7, 'Strasbourg'),
(8, 'Montpellier'),
(9, 'Bordeaux'),
(10, 'Lille'),
(11, 'Rennes'),
(12, 'Reims');

-- --------------------------------------------------------

--
-- Structure de la table `journey`
--

CREATE TABLE `journey` (
  `id` int(11) NOT NULL,
  `depart` varchar(100) NOT NULL,
  `depart_date` date NOT NULL,
  `destination` varchar(100) NOT NULL,
  `destination_date` date NOT NULL,
  `places` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `prenom` varchar(100) DEFAULT NULL,
  `contact` varchar(20) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `nom`, `prenom`, `contact`, `email`, `password`) VALUES
(1, 'Martin', 'Alexandre', '0612345678', 'alexandre.martin@email.fr', '$2y$10$ESQ0lmKbwoLfwuK1BydAEePg5/XmzoEllYH686m62p9SgN1nYbQX6'),
(2, 'Dubois', 'Sophie', '0698765432', 'sophie.dubois@email.fr', '$2y$10$MQ7ZCpV5fZTUpZj4aXvr.uGO.5eKLzCGdLFC/6K2j3MBerLbkABUi'),
(3, 'Bernard', 'Julien', '0622446688', 'julien.bernard@email.fr', '$2y$10$/dwlgw4OIeZ9PIyE0vlkS.qwyLh9J.P24ZV/W6tkqhiWGfaGchn8e'),
(4, 'Moreau', 'Camille', '0611223344', 'camille.moreau@email.fr', '$2y$10$mldjUr4BKnvKRk0LPWTUwegy1uXUmryKnNn.cw807QEjtV9BDRojq'),
(5, 'Lefèvre', 'Lucie', '0777889900', 'lucie.lefevre@email.fr', ''),
(6, 'Leroy', 'Thomas', '0655443322', 'thomas.leroy@email.fr', ''),
(7, 'Roux', 'Chloé', '0633221199', 'chloe.roux@email.fr', ''),
(8, 'Petit', 'Maxime', '0766778899', 'maxime.petit@email.fr', '$2y$10$AgLRlHIf3./f2.2IyAArge3F97v5NbXIMnHtL7/I/Zptlr58.0SXi'),
(9, 'Garnier', 'Laura', '0688776655', 'laura.garnier@email.fr', ''),
(10, 'Dupuis', 'Antoine', '0744556677', 'antoine.dupuis@email.fr', ''),
(11, 'Lefebvre', 'Emma', '0699887766', 'emma.lefebvre@email.fr', ''),
(12, 'Fontaine', 'Louis', '0655667788', 'louis.fontaine@email.fr', ''),
(13, 'Chevalier', 'Clara', '0788990011', 'clara.chevalier@email.fr', ''),
(14, 'Robin', 'Nicolas', '0644332211', 'nicolas.robin@email.fr', ''),
(15, 'Gauthier', 'Marine', '0677889922', 'marine.gauthier@email.fr', ''),
(16, 'Fournier', 'Pierre', '0722334455', 'pierre.fournier@email.fr', ''),
(17, 'Girard', 'Sarah', '0688665544', 'sarah.girard@email.fr', ''),
(18, 'Lambert', 'Hugo', '0611223366', 'hugo.lambert@email.fr', ''),
(19, 'Masson', 'Julie', '0733445566', 'julie.masson@email.fr', ''),
(20, 'Henry', 'Arthur', '0666554433', 'arthur.henry@email.fr', '');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `agencies`
--
ALTER TABLE `agencies`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `journey`
--
ALTER TABLE `journey`
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
-- AUTO_INCREMENT pour la table `agencies`
--
ALTER TABLE `agencies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT pour la table `journey`
--
ALTER TABLE `journey`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
