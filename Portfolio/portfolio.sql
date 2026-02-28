-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : sam. 28 fév. 2026 à 03:10
-- Version du serveur : 5.7.24
-- Version de PHP : 8.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `portfolio`
--

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE `category` (
  `id` int(10) NOT NULL,
  `categories` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id`, `categories`) VALUES
(1, 'Jeux'),
(2, 'Site');

-- --------------------------------------------------------

--
-- Structure de la table `competence`
--

CREATE TABLE `competence` (
  `id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `level` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `competence`
--

INSERT INTO `competence` (`id`, `name`, `level`) VALUES
(2, 'HTML', 'Bonne maîtrise'),
(5, 'JavaScript', 'Bonne maîtrise'),
(6, 'PHP', 'Bonne maîtrise'),
(7, 'React', 'Bon niveau'),
(8, 'Node.js', 'Niveau intermédiaire'),
(9, 'Python', 'Bases solides');

-- --------------------------------------------------------

--
-- Structure de la table `contact_message`
--

CREATE TABLE `contact_message` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `is_read` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `experience`
--

CREATE TABLE `experience` (
  `id` int(10) NOT NULL,
  `image` varchar(2500) NOT NULL,
  `description` varchar(2500) NOT NULL,
  `title` varchar(2500) NOT NULL,
  `short_description` varchar(2500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `experience`
--

INSERT INTO `experience` (`id`, `image`, `description`, `title`, `short_description`) VALUES
(1, 'natixis.png', 'Lors de mon stage chez Natixis, filiale du groupe BPCE, j’ai intégré l’équipe KYC IT, dédiée aux outils et processus liés au Know Your Customer.\r\n\r\nJ’y ai documenté des workflows et des cas d’usage externalisés à eClerx, en analysant les flux, les points de contrôle et les responsabilités afin d’améliorer la clarté et la conformité des processus.\r\n\r\nJ’ai également utilisé Alteryx pour automatiser des traitements de données, en concevant des workflows permettant de nettoyer et consolider des informations issues de différentes sources. Cette automatisation a permis de réduire les tâches manuelles, limiter les erreurs et optimiser l’analyse des processus métiers.', 'Stage De 2 Mois chez Natixis', 'Stage dans la team KYC IT a Natixis');

-- --------------------------------------------------------

--
-- Structure de la table `profil`
--

CREATE TABLE `profil` (
  `id` int(10) NOT NULL,
  `description` varchar(1255) NOT NULL,
  `introduction` varchar(255) NOT NULL,
  `profil_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `profil`
--

INSERT INTO `profil` (`id`, `description`, `introduction`, `profil_image`) VALUES
(1, 'Je m’appelle Max, étudiant en 2ᵉ année à la 3W Academy, où je me forme pour devenir développeur full stack. Actuellement, j\'apprends a travaille avec des technologies comme React, Node.js, TypeScript et Symfony. Ce portfolio est un aperçu de mon parcours, de mes projets et de ma progression dans le développement web.', 'Bienvenue!', 'profil.png');

-- --------------------------------------------------------

--
-- Structure de la table `projet`
--

CREATE TABLE `projet` (
  `id` int(11) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `short_description` varchar(255) NOT NULL,
  `id_category` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `projet`
--

INSERT INTO `projet` (`id`, `titre`, `description`, `image`, `short_description`, `id_category`) VALUES
(1, 'Snake (JS)', 'Lors d\'un sprint de développement, notre groupe a conçu et programmé une version du célebre jeu Snake en utilisant JavaScript, en complément de HTML et CSS. Ce projet nous a permis d\'explorer des concepts clés du développement web, d\'améliorer notre travail d\'équipe et d\'affiner notre gestion du temps dans un cadre Agile.\r\n\r\n', 'snake.png', 'Un jeu code en JavaScript', 1),
(3, 'Chat Anonyme', 'Lors d’un projet de développement, nous avons créé un chat anonyme en utilisant PHP, structuré selon le modèle MVC. Cette application permet aux utilisateurs de discuter en temps réel sans créer de compte, garantissant un anonymat complet. Ce projet nous a permis de renforcer notre compréhension de la séparation entre la logique, l’affichage et le contrôle dans une application web, tout en améliorant notre organisation et notre capacité à structurer un code clair et modulable.', 'chat.png', 'Un chat anomyme pour le MVC', 2),
(4, 'Carnet d\'addresse', 'Lors d’un projet de développement, nous avons conçu un carnet d’adresses interactif en utilisant React. Cette application permet d’ajouter, modifier et organiser facilement des contacts, offrant une expérience utilisateur fluide et réactive. Le projet nous a permis d’explorer les concepts clés de React, comme les composants, l’état et les props, tout en renforçant notre organisation et notre capacité à structurer une application web moderne et modulable.', 'carnet.png', 'Un carnet d\'addresse fait avec React', NULL),
(5, 'Mini Reseau social', 'Lors d’un projet en groupe, nous avons développé un mini réseau social en utilisant Symfony et Docker. L’application permet aux utilisateurs de créer un compte, publier des post et interagir entre eux, offrant une expérience sociale simple et fonctionnelle. Ce projet nous a permis de travailler en équipe tout en découvrant la gestion d’environnements conteneurisés avec Docker et l’architecture d’une application Symfony, renforçant à la fois nos compétences techniques et notre organisation collaborative.', 'reseau.png', 'Un Reseau social fait avec docker et symfony', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(10) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `password`) VALUES
(1, 'max.pham@free.fr', '$2a$12$Tg4ao9HZlwwSS0U2zgV5we0RUUzh7cRkUSjrO5PxuLK.3R.rHhaNa'),
(5, 'admin@admin.fr', '$2y$10$3CsS8SeMgH52vvfM1EDIGuUnjV2ipQ6lDq4o/9MZAuM040dP2mL3y');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `competence`
--
ALTER TABLE `competence`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `contact_message`
--
ALTER TABLE `contact_message`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `experience`
--
ALTER TABLE `experience`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `profil`
--
ALTER TABLE `profil`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `projet`
--
ALTER TABLE `projet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_category` (`id_category`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `competence`
--
ALTER TABLE `competence`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `contact_message`
--
ALTER TABLE `contact_message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `experience`
--
ALTER TABLE `experience`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `profil`
--
ALTER TABLE `profil`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `projet`
--
ALTER TABLE `projet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `projet`
--
ALTER TABLE `projet`
  ADD CONSTRAINT `projet_ibfk_1` FOREIGN KEY (`id_category`) REFERENCES `category` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
