-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 13 oct. 2021 à 11:24
-- Version du serveur : 10.4.21-MariaDB
-- Version de PHP : 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `animaleries`
--

-- --------------------------------------------------------

--
-- Structure de la table `animal`
--

CREATE TABLE `animal` (
  `id_animal` int(11) NOT NULL,
  `nom` varchar(250) NOT NULL,
  `race` varchar(250) NOT NULL,
  `id_categorie` int(100) NOT NULL,
  `poids` varchar(11) NOT NULL,
  `age` varchar(11) NOT NULL,
  `cout` varchar(11) NOT NULL,
  `taille` varchar(11) NOT NULL,
  `id_fourrure` int(250) NOT NULL,
  `image` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `animal`
--

INSERT INTO `animal` (`id_animal`, `nom`, `race`, `id_categorie`, `poids`, `age`, `cout`, `taille`, `id_fourrure`, `image`) VALUES
(2, 'Berger', 'Berger Allemand', 1, '2.5', '11', '300000', '0.9', 3, 'appareil-architecte.png'),
(3, 'Ollo', 'Caniche', 2, '10', '11', '150000', '1.20', 2, '1algo-google.jpg'),
(4, 'animal', 'race', 1, '12', '13', '125000', '1.5', 1, 'question-reponse.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `id_categorie` int(11) NOT NULL,
  `categorie` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`id_categorie`, `categorie`) VALUES
(1, 'categorie d\'animal 1'),
(2, 'categorie d\'animal 2'),
(3, 'categorie d\'animal 3'),
(5, 'categorie d\'animal 5');

-- --------------------------------------------------------

--
-- Structure de la table `categorie_oiseaux`
--

CREATE TABLE `categorie_oiseaux` (
  `id_categorie_oiseau` int(11) NOT NULL,
  `categorie_oiseau` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `categorie_oiseaux`
--

INSERT INTO `categorie_oiseaux` (`id_categorie_oiseau`, `categorie_oiseau`) VALUES
(1, 'categorie oiseau 1'),
(2, 'categorie oiseau 2'),
(3, 'categorie d\'oiseau 3'),
(4, 'categorie d\'oiseau 4'),
(6, 'categorie d\'oiseau 5');

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

CREATE TABLE `clients` (
  `id_client` int(11) NOT NULL,
  `nom` varchar(250) NOT NULL,
  `adresse` varchar(250) NOT NULL,
  `telephone` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `clients`
--

INSERT INTO `clients` (`id_client`, `nom`, `adresse`, `telephone`) VALUES
(3, 'Client 1', 'Adresse 1', 504060102),
(4, 'Client 2', 'Adresse 2', 701020304);

-- --------------------------------------------------------

--
-- Structure de la table `fourrure`
--

CREATE TABLE `fourrure` (
  `id_fourrure` int(11) NOT NULL,
  `fourrure` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `fourrure`
--

INSERT INTO `fourrure` (`id_fourrure`, `fourrure`) VALUES
(1, 'f1'),
(2, 'f2'),
(3, 'fourrure 3'),
(4, 'fourrure 4');

-- --------------------------------------------------------

--
-- Structure de la table `oiseaux`
--

CREATE TABLE `oiseaux` (
  `id_oiseau` int(11) NOT NULL,
  `nom` varchar(250) NOT NULL,
  `cout` int(11) NOT NULL,
  `id_categorie_oiseau` int(11) NOT NULL,
  `bruit` varchar(250) NOT NULL,
  `image` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `oiseaux`
--

INSERT INTO `oiseaux` (`id_oiseau`, `nom`, `cout`, `id_categorie_oiseau`, `bruit`, `image`) VALUES
(1, 'oiseau 2', 125000, 4, 'bruit 2', '1.png'),
(3, 'Oiseau 1', 120000, 3, 'bruit 1', 'wd.jpg'),
(4, 'oiseau 0', 210000, 2, 'bruit 0', 'wd1png.png'),
(6, 'oiseau 01', 210000, 1, 'bruit 01', 'site-ecommerce-donnees-sensibles.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

CREATE TABLE `produit` (
  `id_produit` int(11) NOT NULL,
  `libelle` varchar(250) NOT NULL,
  `stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`id_produit`, `libelle`, `stock`) VALUES
(2, 'produit 1', 20),
(3, 'produit 2', 130);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `pseudo` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `pass` varchar(250) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `pseudo`, `email`, `pass`, `date`) VALUES
(1, 'Cheick', 'cheick@g.be', '1234', '2021-10-07 15:06:13'),
(2, 'ARMAND', 'armand@g.be', '1234', '2021-10-07 15:14:20'),
(3, 'Cool', 'cool@gmail.com', '1234', '2021-10-07 16:28:17'),
(4, 'Kalil', 'kalil@gmail.com', '2345', '2021-10-09 13:32:40'),
(5, 'Fall', 'fall@gmail.com', '4567', '2021-10-10 20:45:52'),
(6, 'ok', 'ok@gmail.com', '1234', '2021-10-12 01:04:30');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `animal`
--
ALTER TABLE `animal`
  ADD PRIMARY KEY (`id_animal`),
  ADD KEY `categorie` (`id_categorie`),
  ADD KEY `fourrure` (`id_fourrure`);

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id_categorie`);

--
-- Index pour la table `categorie_oiseaux`
--
ALTER TABLE `categorie_oiseaux`
  ADD PRIMARY KEY (`id_categorie_oiseau`);

--
-- Index pour la table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id_client`);

--
-- Index pour la table `fourrure`
--
ALTER TABLE `fourrure`
  ADD PRIMARY KEY (`id_fourrure`);

--
-- Index pour la table `oiseaux`
--
ALTER TABLE `oiseaux`
  ADD PRIMARY KEY (`id_oiseau`),
  ADD KEY `id_categorie` (`id_categorie_oiseau`);

--
-- Index pour la table `produit`
--
ALTER TABLE `produit`
  ADD PRIMARY KEY (`id_produit`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `animal`
--
ALTER TABLE `animal`
  MODIFY `id_animal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id_categorie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `categorie_oiseaux`
--
ALTER TABLE `categorie_oiseaux`
  MODIFY `id_categorie_oiseau` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `clients`
--
ALTER TABLE `clients`
  MODIFY `id_client` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `fourrure`
--
ALTER TABLE `fourrure`
  MODIFY `id_fourrure` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `oiseaux`
--
ALTER TABLE `oiseaux`
  MODIFY `id_oiseau` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `produit`
--
ALTER TABLE `produit`
  MODIFY `id_produit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
