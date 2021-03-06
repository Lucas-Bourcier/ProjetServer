-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 04 mars 2022 à 11:27
-- Version du serveur : 10.4.19-MariaDB
-- Version de PHP : 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE proxmox;
USE proxmox;

--
-- Base de données : `proxmox`
--

-- --------------------------------------------------------

--
-- Structure de la table `dns`
--

CREATE TABLE `dns` (
  `id` int(11) NOT NULL,
  `ipAddress` varchar(15) DEFAULT NULL,
  `port` int(11) DEFAULT NULL,
  `dnsName` varchar(255) DEFAULT NULL,
  `idServer` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `groupe`
--

CREATE TABLE `groupe` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `route`
--

CREATE TABLE `route` (
  `id` int(11) NOT NULL,
  `portOrigin` int(11) DEFAULT NULL,
  `portDest` int(11) DEFAULT NULL,
  `hostDest` varchar(15) DEFAULT NULL,
  `order_` int(11) DEFAULT NULL,
  `idServer` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `serveur`
--

CREATE TABLE `serveur` (
  `id` int(11) NOT NULL,
  `ipAddress` varchar(15) DEFAULT NULL,
  `dnsName` varchar(255) DEFAULT NULL,
  `login` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `service`
--

CREATE TABLE `service` (
  `id` int(11) NOT NULL,
  `service` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `usergroups`
--

CREATE TABLE `usergroups` (
  `idUser` int(11) NOT NULL,
  `idGroupe` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `userservers`
--

CREATE TABLE `userservers` (
  `id` int(11) NOT NULL,
  `id_1` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `user_`
--

CREATE TABLE `user_` (
  `id` int(11) NOT NULL,
  `login` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `gitHub` varchar(250) DEFAULT NULL,
  `linkedin` varchar(200) DEFAULT NULL,
  `image` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `user_`
--

INSERT INTO `user_` (`id`, `login`, `password`, `role`, `description`, `gitHub`, `linkedin`, `image`) VALUES
(1, 'toto', '$2y$10$rNOKTKg7e9LIA8bmu51Boe2dDOai4vRbpH/sHrxOy2QJIbHc0LtUm', '@ADMIN', 'Dieu est tout puissant.', 'https://github.com/Thomas-roulland', 'https://www.linkedin.com/in/thomas-roulland-128a691b5/', 'assets/img/admin.png');

-- --------------------------------------------------------

--
-- Structure de la table `vm`
--

CREATE TABLE `vm` (
  `id` int(11) NOT NULL,
  `number` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `ip` varchar(15) DEFAULT NULL,
  `sshPort` int(11) DEFAULT NULL,
  `os` varchar(255) DEFAULT NULL,
  `idUser` int(11) DEFAULT NULL,
  `idServeur` int(11) NOT NULL,
  `idGroupe` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `vmservices`
--

CREATE TABLE `vmservices` (
  `idVm` int(11) NOT NULL,
  `idService` int(11) NOT NULL,
  `port` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `dns`
--
ALTER TABLE `dns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idServer` (`idServer`);

--
-- Index pour la table `groupe`
--
ALTER TABLE `groupe`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `route`
--
ALTER TABLE `route`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idServer` (`idServer`);

--
-- Index pour la table `serveur`
--
ALTER TABLE `serveur`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `usergroups`
--
ALTER TABLE `usergroups`
  ADD PRIMARY KEY (`idUser`,`idGroupe`),
  ADD KEY `idGroupe` (`idGroupe`);

--
-- Index pour la table `userservers`
--
ALTER TABLE `userservers`
  ADD PRIMARY KEY (`id`,`id_1`),
  ADD KEY `id_1` (`id_1`);

--
-- Index pour la table `user_`
--
ALTER TABLE `user_`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `vm`
--
ALTER TABLE `vm`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idUser` (`idUser`),
  ADD KEY `idServeur` (`idServeur`),
  ADD KEY `idGroupe` (`idGroupe`);

--
-- Index pour la table `vmservices`
--
ALTER TABLE `vmservices`
  ADD PRIMARY KEY (`idVm`,`idService`),
  ADD KEY `idService` (`idService`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `dns`
--
ALTER TABLE `dns`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `groupe`
--
ALTER TABLE `groupe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `route`
--
ALTER TABLE `route`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `serveur`
--
ALTER TABLE `serveur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `service`
--
ALTER TABLE `service`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `user_`
--
ALTER TABLE `user_`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `vm`
--
ALTER TABLE `vm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `dns`
--
ALTER TABLE `dns`
  ADD CONSTRAINT `dns_ibfk_1` FOREIGN KEY (`idServer`) REFERENCES `serveur` (`id`);

--
-- Contraintes pour la table `route`
--
ALTER TABLE `route`
  ADD CONSTRAINT `route_ibfk_1` FOREIGN KEY (`idServer`) REFERENCES `serveur` (`id`);

--
-- Contraintes pour la table `usergroups`
--
ALTER TABLE `usergroups`
  ADD CONSTRAINT `usergroups_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `user_` (`id`),
  ADD CONSTRAINT `usergroups_ibfk_2` FOREIGN KEY (`idGroupe`) REFERENCES `groupe` (`id`);

--
-- Contraintes pour la table `userservers`
--
ALTER TABLE `userservers`
  ADD CONSTRAINT `userservers_ibfk_1` FOREIGN KEY (`id`) REFERENCES `user_` (`id`),
  ADD CONSTRAINT `userservers_ibfk_2` FOREIGN KEY (`id_1`) REFERENCES `serveur` (`id`);

--
-- Contraintes pour la table `vm`
--
ALTER TABLE `vm`
  ADD CONSTRAINT `vm_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `user_` (`id`),
  ADD CONSTRAINT `vm_ibfk_2` FOREIGN KEY (`idServeur`) REFERENCES `serveur` (`id`),
  ADD CONSTRAINT `vm_ibfk_3` FOREIGN KEY (`idGroupe`) REFERENCES `groupe` (`id`);

--
-- Contraintes pour la table `vmservices`
--
ALTER TABLE `vmservices`
  ADD CONSTRAINT `vmservices_ibfk_1` FOREIGN KEY (`idVm`) REFERENCES `vm` (`id`),
  ADD CONSTRAINT `vmservices_ibfk_2` FOREIGN KEY (`idService`) REFERENCES `service` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
