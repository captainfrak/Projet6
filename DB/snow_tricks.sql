-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le :  ven. 17 jan. 2020 à 10:48
-- Version du serveur :  10.3.21-MariaDB
-- Version de PHP :  7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `sasy8854_db_snow_tricks`
--

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `trick_id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `content` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `migration_versions`
--

CREATE TABLE `migration_versions` (
  `version` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `executed_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migration_versions`
--

INSERT INTO `migration_versions` (`version`, `executed_at`) VALUES
('20191113095509', '2019-11-13 09:55:31'),
('20191119211100', '2019-11-19 21:11:28'),
('20191125133800', '2019-11-25 13:38:30'),
('20191130093100', '2019-11-30 09:31:28'),
('20191203155958', '2019-12-03 16:00:25'),
('20191214131013', '2019-12-17 15:24:23'),
('20191223084339', '2019-12-23 08:44:57'),
('20191223093508', '2019-12-23 09:35:22'),
('20200108092741', '2020-01-08 09:28:10'),
('20200112123042', '2020-01-12 12:32:01');

-- --------------------------------------------------------

--
-- Structure de la table `profile_pic`
--

CREATE TABLE `profile_pic` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `profile_pic`
--

INSERT INTO `profile_pic` (`id`, `user_id`, `name`) VALUES
(9, 1, '67e7b63fb52cff517308bbdd7f09e1ea.jpeg'),
(11, NULL, ''),
(14, NULL, '');

-- --------------------------------------------------------

--
-- Structure de la table `trick`
--

CREATE TABLE `trick` (
  `id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `figure_group` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `trick`
--

INSERT INTO `trick` (`id`, `author_id`, `name`, `description`, `figure_group`, `created_at`) VALUES
(24, 1, 'Backside Air', 'a venir', 'Grab', '2020-01-17 09:31:26'),
(25, 1, '180', 'La base des bases !', 'Rotation', '2020-01-17 09:42:43'),
(26, 1, 'Japan Air', 'a venir', 'Grab', '2020-01-17 09:52:54'),
(27, 1, '1080', '3 tours sur soit et réception en prime !', 'Rotation', '2020-01-17 09:57:56'),
(28, 1, 'Slide', 'Un slide consiste à glisser sur une barre de slide. Le slide se fait soit avec la planche dans l\'axe de la barre, soit perpendiculaire, soit plus ou moins désaxé.  On peut slider avec la planche centrée par rapport à la barre (celle-ci se situe approximativement au-dessous des pieds du rideur), mais aussi en nose slide, c\'est-à-dire l\'avant de la planche sur la barre, ou en tail slide, l\'arrière de la planche sur la barre.', 'Slide', '2020-01-17 10:03:07'),
(29, 1, 'FrontFlip', 'Rotation en avant!', 'Flip', '2020-01-17 10:11:50'),
(30, 1, 'Backside Cork 540', 'Truc de malade !!!', 'Rotation Désaxée', '2020-01-17 10:16:00'),
(31, 1, 'Indy', 'On vient attraper la board pendant un saut', 'Grab', '2020-01-17 10:21:31');

-- --------------------------------------------------------

--
-- Structure de la table `trick_group`
--

CREATE TABLE `trick_group` (
  `id` int(11) NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `trick_group`
--

INSERT INTO `trick_group` (`id`, `category`) VALUES
(1, 'Grab'),
(2, 'Rotation'),
(3, 'Flip'),
(4, 'Rotation Désaxée'),
(5, 'Slide'),
(6, 'One Foot');

-- --------------------------------------------------------

--
-- Structure de la table `trick_pic`
--

CREATE TABLE `trick_pic` (
  `id` int(11) NOT NULL,
  `trick_id` int(11) NOT NULL,
  `pic_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `trick_pic`
--

INSERT INTO `trick_pic` (`id`, `trick_id`, `pic_name`) VALUES
(25, 25, '8780d9a2d3b1fb7521c3269aa54daf69.jpeg'),
(26, 25, 'c7a05805aa6d1f207c970847dfc25249.jpeg'),
(27, 25, 'ddd47f7649636799a3c8ee9b0225ee37.jpeg'),
(28, 26, '4f08018a57d7733be212b452a62ce4c9.jpeg'),
(29, 27, 'fe0e223a59b65fb5117063b3c6a52c1e.jpeg'),
(30, 28, '01a14c243def8e6aad78f5e7a84da13e.jpeg'),
(31, 29, '22f83c31603fd1c49e4592e2bcbe2230.jpeg'),
(32, 30, 'b841e8de2fdb78a49fb73ad129fa28e4.jpeg'),
(33, 31, 'c64c64788eeedd40f4eef510eb40fcaa.jpeg');

-- --------------------------------------------------------

--
-- Structure de la table `trick_vid`
--

CREATE TABLE `trick_vid` (
  `id` int(11) NOT NULL,
  `trick_id` int(11) NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `trick_vid`
--

INSERT INTO `trick_vid` (`id`, `trick_id`, `url`) VALUES
(6, 24, 'www.youtube.com/embed/h0UtyOX9p90'),
(7, 25, 'www.youtube.com/embed/JMS2PGAFMcE'),
(8, 26, 'www.youtube.com/embed/CzDjM7h_Fwo'),
(9, 27, 'www.youtube.com/embed/_3C02T-4Uug'),
(10, 28, 'www.youtube.com/embed/j0kiJCsEUBs'),
(11, 29, 'www.youtube.com/embed/qvnsjVJCbA0'),
(12, 30, 'https://www.youtube.com/embed/P5ZI-d-eHsI'),
(13, 31, 'https://www.youtube.com/embed/iKkhKekZNQ8');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `token`, `username`) VALUES
(1, 'a@a.com', '[]', '$2y$13$iXM3OolrfTXvm4shO9iDHOsCKTFEZvmq4AHghd9T0gRsUG3Gmzb1e', NULL, 'Alfred'),
(3, 'b@b.com', '[]', '$2y$13$i7nOMuJMzbnbP6Bphm5kDO.K/4ecfe1P47MVy0tk/WJOoNxgoB03e', '94a72849aad9e3d26a1e966111ee89e0', 'bertrant'),
(4, 'cpt.frak@me.com', '[]', '$argon2i$v=19$m=65536,t=4,p=1$d0lpd1JCeVdmb3hjZnNCTw$c77Mh+Fi3Os3wxLWVqeZ+fPZcILIZ59L7pSdXtUcVGo', 'b34161174bd2e264f7ec86a19c9837ba', 'captainfrak');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_9474526CB281BE2E` (`trick_id`),
  ADD KEY `IDX_9474526CF675F31B` (`author_id`);

--
-- Index pour la table `migration_versions`
--
ALTER TABLE `migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `profile_pic`
--
ALTER TABLE `profile_pic`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_6596F871A76ED395` (`user_id`);

--
-- Index pour la table `trick`
--
ALTER TABLE `trick`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_D8F0A91E5E237E06` (`name`),
  ADD KEY `IDX_D8F0A91EF675F31B` (`author_id`);

--
-- Index pour la table `trick_group`
--
ALTER TABLE `trick_group`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `trick_pic`
--
ALTER TABLE `trick_pic`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_7C84B5ACB281BE2E` (`trick_id`);

--
-- Index pour la table `trick_vid`
--
ALTER TABLE `trick_vid`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_E66D5CBDB281BE2E` (`trick_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `profile_pic`
--
ALTER TABLE `profile_pic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `trick`
--
ALTER TABLE `trick`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT pour la table `trick_group`
--
ALTER TABLE `trick_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `trick_pic`
--
ALTER TABLE `trick_pic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT pour la table `trick_vid`
--
ALTER TABLE `trick_vid`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `FK_9474526CB281BE2E` FOREIGN KEY (`trick_id`) REFERENCES `trick` (`id`),
  ADD CONSTRAINT `FK_9474526CF675F31B` FOREIGN KEY (`author_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `profile_pic`
--
ALTER TABLE `profile_pic`
  ADD CONSTRAINT `FK_6596F871A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `trick`
--
ALTER TABLE `trick`
  ADD CONSTRAINT `FK_D8F0A91EF675F31B` FOREIGN KEY (`author_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `trick_pic`
--
ALTER TABLE `trick_pic`
  ADD CONSTRAINT `FK_7C84B5ACB281BE2E` FOREIGN KEY (`trick_id`) REFERENCES `trick` (`id`);

--
-- Contraintes pour la table `trick_vid`
--
ALTER TABLE `trick_vid`
  ADD CONSTRAINT `FK_E66D5CBDB281BE2E` FOREIGN KEY (`trick_id`) REFERENCES `trick` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
