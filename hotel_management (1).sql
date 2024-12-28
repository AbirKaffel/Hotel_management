-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : sam. 28 déc. 2024 à 20:11
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
-- Base de données : `hotel_management`
--

-- --------------------------------------------------------

--
-- Structure de la table `chambres`
--

CREATE TABLE `chambres` (
  `id` int(255) NOT NULL,
  `numero` int(15) NOT NULL,
  `type` varchar(50) NOT NULL,
  `prix` decimal(10,2) NOT NULL,
  `capacite` int(20) NOT NULL,
  `statut` enum('disponible','occupee','','') NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `chambres`
--

INSERT INTO `chambres` (`id`, `numero`, `type`, `prix`, `capacite`, `statut`, `image`) VALUES
(7, 1, 'single', 55.00, 1, 'disponible', 'uploads/674642e3f39a2-pexels-pixabay-271618.jpg'),
(8, 2, 'double', 100.00, 2, 'disponible', 'uploads/674643f2528df-20220616171236.jpeg'),
(9, 3, 'honeymoon suite', 150.00, 2, 'disponible', 'uploads/67464408c79ba-images.jfif'),
(10, 4, 'Deluxe Room', 150.00, 2, 'disponible', 'uploads/676981b8d5be2-img6.jpg'),
(11, 5, 'Luxury Suite', 170.00, 2, 'disponible', 'uploads/676981eabda7c-img2.jpeg'),
(13, 6, 'Presidential Suite', 200.00, 2, 'disponible', 'uploads/676983043f044-img7.webp'),
(14, 8, 'Deluxe Room', 900.00, 2, 'disponible', 'uploads/676acce477762-img6.jpg'),
(15, 10, 'Presidential Suite', 250.00, 2, 'disponible', 'uploads/676acfa463e41-img2.jpeg');

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

CREATE TABLE `clients` (
  `id` int(255) NOT NULL,
  `nom` varchar(250) NOT NULL,
  `prenom` varchar(250) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telephone` int(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL DEFAULT 'client'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `clients`
--

INSERT INTO `clients` (`id`, `nom`, `prenom`, `email`, `telephone`, `password`, `role`) VALUES
(5, 'kaffel', 'abir', 'kaffelabir@gmail.com', 29853021, '$2y$10$vvhzMUne7UVxTftowXrHW.xqbONlmyynbv5tOEfc8QeV6DkYKqKp.', 'admin'),
(10, 'wllha', 'najla ', 'nj@gmail.com', 29853037, '$2y$10$/ceZaFq39sdL7eb6dza7TOd1Xw4AVJ67JDt70rQ7Pd.8zuTGLGxbm', 'client'),
(11, 'fairouz', 'rekik', 're@gmail.com', 22212981, '$2y$10$kAmRLBx6ufXc5FWH0ZTpoOOdCn6f8IuqWVJ4Wb6tflPrhOxERuvYu', 'client'),
(12, 'Bellaj ', 'Mohsen ', 'behu@gmail.com', 44725601, '$2y$10$edJw/kI96doXLSprLrHT3ujH74L.rPeWi0O5Navhd6Zx3Siug5WgO', 'client'),
(13, 'test', 'test ', 'test@gmail.com', 2212981, '$2y$10$oDsD5fkq7QdZcbjY.Of/VO27d09mJ2YuVH6l/MQGEaqTj3iJIFpke', 'client'),
(14, 'test', 'test1', 'test1@gmail.com', 2986531, '$2y$10$aSqtIAuxFuGIW6D2zcBcpOQ1ass5GXDcxf7/Gv5axAxYydOoFUhK2', 'client'),
(15, 'test2', 'test2', 'test2@gmail.com', 22212981, '$2y$10$agh/gtMhYGkPC1XgY9GFnuQ7VNwi3UtH50MJV4WtoH7wgLsTJqjGm', 'client'),
(19, 'test3', 'test3', 'test3@gmail.com', 2212981, '$2y$10$r8h7yO0irFIs9jw/84B9PewBr.rqSuTgRiMgYH49DHAUT7X0jykJy', 'client'),
(21, 'test4', 'test4', 'test4@gmail.com', 22212981, '$2y$10$cQAdLo8tSYuGvq0tlDPXdeNiizF6A5uRg6XBYdQ.6.Nz2i4rmBN/6', 'client');

-- --------------------------------------------------------

--
-- Structure de la table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(255) NOT NULL,
  `client_id` int(250) NOT NULL,
  `chambre_id` int(250) NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `statut` enum('confirmée','annulée','en_attente') NOT NULL DEFAULT 'en_attente'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `reservations`
--

INSERT INTO `reservations` (`id`, `client_id`, `chambre_id`, `date_debut`, `date_fin`, `statut`) VALUES
(11, 5, 8, '2024-12-21', '2024-12-22', 'confirmée'),
(15, 12, 8, '2024-12-01', '2024-12-01', 'annulée'),
(16, 13, 7, '2025-01-19', '2024-12-20', 'confirmée'),
(18, 19, 11, '2024-12-24', '2024-12-24', 'annulée'),
(19, 19, 13, '2024-12-24', '2024-12-24', 'confirmée'),
(20, 19, 13, '2024-12-26', '2024-12-26', 'annulée'),
(21, 21, 11, '2024-12-28', '2024-12-28', 'confirmée'),
(22, 5, 9, '2024-12-22', '2024-12-29', 'en_attente');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `chambres`
--
ALTER TABLE `chambres`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chambre_id` (`chambre_id`),
  ADD KEY `client_id` (`client_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `chambres`
--
ALTER TABLE `chambres`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT pour la table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`chambre_id`) REFERENCES `chambres` (`id`),
  ADD CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
