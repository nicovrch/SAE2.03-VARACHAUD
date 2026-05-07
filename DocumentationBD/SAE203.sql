-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : jeu. 07 mai 2026 à 14:46
-- Version du serveur : 8.0.45-0ubuntu0.24.04.1
-- Version de PHP : 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `SAE203`
--

-- --------------------------------------------------------

--
-- Structure de la table `Category`
--

CREATE TABLE `Category` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `Category`
--

INSERT INTO `Category` (`id`, `name`) VALUES
(1, 'Action'),
(2, 'Comédie'),
(3, 'Drame'),
(4, 'Science-fiction'),
(5, 'Animation'),
(6, 'Thriller'),
(7, 'Horreur'),
(8, 'Aventure'),
(9, 'Fantaisie'),
(10, 'Documentaire');

-- --------------------------------------------------------

--
-- Structure de la table `Favorite`
--

CREATE TABLE `Favorite` (
  `id_profile` int NOT NULL,
  `id_movie` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `Favorite`
--

INSERT INTO `Favorite` (`id_profile`, `id_movie`) VALUES
(1, 7),
(4, 7),
(1, 17),
(1, 27),
(1, 32);

-- --------------------------------------------------------

--
-- Structure de la table `Movie`
--

CREATE TABLE `Movie` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `year` int DEFAULT NULL,
  `length` int DEFAULT NULL,
  `description` text,
  `director` varchar(255) DEFAULT NULL,
  `id_category` int DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `trailer` varchar(255) DEFAULT NULL,
  `min_age` int DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `Movie`
--

INSERT INTO `Movie` (`id`, `name`, `year`, `length`, `description`, `director`, `id_category`, `image`, `trailer`, `min_age`, `is_featured`) VALUES
(7, 'Interstellar', 2014, 169, 'Un groupe d\'explorateurs voyage à travers un trou de ver pour sauver l\'humanité.', 'Christopher Nolan', 4, 'interstellar.png', 'https://www.youtube.com/embed/VaOijhK3CRU?si=76Ke4uw4LYjuLuQ6', 12, 1),
(12, 'La Liste de Schindler', 1993, 195, 'Un industriel allemand sauve des milliers de Juifs pendant l\'Holocauste.', 'Steven Spielberg', 3, 'schindler.png', 'https://www.youtube.com/embed/ONWtyxzl-GE?si=xC3ASGGPy5Ib-aPn', 16, 1),
(17, 'Your Name', 2016, 107, 'Deux adolescents échangent leurs corps de manière mystérieuse.', 'Makoto Shinkai', 5, 'your_name.png', 'https://www.youtube.com/embed/AROOK45LXXg?si=aUQyGk2VMCb_ToUL', 10, 1),
(27, 'Le Bon, la Brute et le Truand', 1966, 161, 'Trois hommes se lancent à la recherche d\'un trésor caché.', 'Sergio Leone', 8, 'bon_brute_truand.png', 'https://www.youtube.com/embed/WA1hCZFOPqs?si=TwNZAoM4oj4KpGja', 12, 1),
(32, 'Projet X', 2012, 88, 'fête', 'Nima Nourizadeh', 2, 'Projet_X.png', 'https://www.youtube.com/embed/Kfm4Z4C2NRo?si=rjMux7QdD-9o90n0', 10, 1),
(33, 'Ça', 2017, 135, 'film d\'horreur', 'Andrés Muschietti', 6, 'ca-affiche.png', 'https://www.youtube.com/embed/Tw3yT-qAbvc?si=1eiu9UtzA2epYOSa', 18, 0),
(35, 'Kin : Le Commencement', 2018, 102, 'Ptit garçon avec des pouvoirs', 'Jonathan Baker et Josh Baker', 1, 'kin.png', 'https://www.youtube.com/embed/KGsqiAF6MJk?si=sKNrgSl9UP8XL12X', 16, 1),
(36, 'Coco', 2017, 105, 'Ptit gars qui va voir les morts', 'Lee Unkrich et Adrian Molina', 8, 'coco.png', 'https://www.youtube.com/embed/KGsqiAF6MJk?si=sKNrgSl9UP8XL12X', 0, 1),
(37, 'Solo: A Star Wars Story', 2018, 135, 'Histoire de Han Solo', 'Ron Howard', 4, 'solo.png', 'https://www.youtube.com/embed/mJUsd9D9NW0?si=St4bZKZbC7y2JopG', 16, 1),
(38, 'Rogue One : A Star Wars Story', 2016, 133, 'Transition star wars 6/7', 'Gareth Edwards', 4, 'rogueone.png', 'https://www.youtube.com/embed/ox6Dsbvp7ng?si=ujXNZN7zbqMwt-J0', 16, 0),
(39, 'Kuroko\'s Basketball, le film : THE LAST GAME', 2017, 90, 'Suite et fin de l\'anime ', 'Shunsuke Tada', 5, 'kuroko.png', 'https://www.youtube.com/embed/vE7-kfCmxL4?si=UWNOE9Ox_Fycw46O', 0, 0),
(40, 'Bubble', 2022, 100, 'Chute de Tokyo et anime de parcours', 'Tetsuro Araki', 5, 'buble.png', 'https://www.youtube.com/embed/URfZnqqDfs4?si=8oqhp1Pa8Brpa7dW', 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `Profile`
--

CREATE TABLE `Profile` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `min_age` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `Profile`
--

INSERT INTO `Profile` (`id`, `name`, `avatar`, `min_age`) VALUES
(1, 'omar', '', 18),
(4, 'pablito', NULL, 12),
(5, 'baptiste', NULL, 16);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `Category`
--
ALTER TABLE `Category`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `Favorite`
--
ALTER TABLE `Favorite`
  ADD PRIMARY KEY (`id_profile`,`id_movie`),
  ADD KEY `id_movie` (`id_movie`);

--
-- Index pour la table `Movie`
--
ALTER TABLE `Movie`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_category` (`id_category`);

--
-- Index pour la table `Profile`
--
ALTER TABLE `Profile`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `Category`
--
ALTER TABLE `Category`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `Movie`
--
ALTER TABLE `Movie`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT pour la table `Profile`
--
ALTER TABLE `Profile`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `Favorite`
--
ALTER TABLE `Favorite`
  ADD CONSTRAINT `Favorite_ibfk_1` FOREIGN KEY (`id_profile`) REFERENCES `Profile` (`id`),
  ADD CONSTRAINT `Favorite_ibfk_2` FOREIGN KEY (`id_movie`) REFERENCES `Movie` (`id`);

--
-- Contraintes pour la table `Movie`
--
ALTER TABLE `Movie`
  ADD CONSTRAINT `movie_ibfk_1` FOREIGN KEY (`id_category`) REFERENCES `Category` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
