-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 25 juil. 2025 à 11:01
-- Version du serveur : 9.1.0
-- Version de PHP : 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `vulnmarket`
--

-- --------------------------------------------------------

--
-- Structure de la table `applications`
--

DROP TABLE IF EXISTS `applications`;
CREATE TABLE IF NOT EXISTS `applications` (
  `id` int NOT NULL AUTO_INCREMENT,
  `job_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `cv_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `applications`
--

INSERT INTO `applications` (`id`, `job_id`, `user_id`, `cv_path`, `created_at`) VALUES
(1, 2, 1, 'dummy_cv_path', '2025-07-24 12:31:19');

-- --------------------------------------------------------

--
-- Structure de la table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text,
  `user_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

DROP TABLE IF EXISTS `flag`;
CREATE TABLE IF NOT EXISTS `flag` (
  `id` int NOT NULL AUTO_INCREMENT,
  `flag_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb3;

INSERT INTO `flag` (`id`, `flag_name`, `created_at`) VALUES
(1, 'spider{Hell0_W3b_Flag_1110}', NOW());

--
-- Déchargement des données de la table `jobs`
--

-- Déchargement des données de la table `jobs`
INSERT INTO `jobs` (`id`, `title`, `description`, `user_id`, `created_at`) VALUES
(1, 'Frontend Developer', 'Build responsive UIs.', 1, '2025-07-24 12:28:50'),
(2, 'Backend Developer', 'Maintain APIs and business logic.', 1, '2025-07-24 12:29:05'),
(3, 'Full Stack Engineer', 'Work on both frontend and backend.', 1, NOW()),
(4, 'DevOps Engineer', 'Automate deployment pipelines.', 1, NOW()),
(5, 'Cybersecurity Analyst', 'Monitor and protect systems.', 1, NOW()),
(6, 'Data Scientist', 'Analyze and visualize data.', 1, NOW()),
(7, 'UX Designer', 'Improve user experience.', 1, NOW()),
(8, 'QA Engineer', 'Test and ensure quality.', 1, NOW()),
(9, 'Mobile Developer', 'Develop Android/iOS apps.', 1, NOW()),
(10, 'Cloud Architect', 'Design scalable infrastructure.', 1, NOW()),
(11, 'AI Engineer', 'Implement machine learning models.', 1, NOW()),
(12, 'Database Administrator', 'Manage relational databases.', 1, NOW()),
(13, 'IT Support Specialist', 'Help users resolve tech issues.', 1, NOW()),
(14, 'Technical Writer', 'Create product documentation.', 1, NOW()),
(15, 'Project Manager', 'Coordinate development teams.', 1, NOW()),
(16, 'Product Owner', 'Define and prioritize product features.', 1, NOW()),
(17, 'Scrum Master', 'Facilitate Agile ceremonies.', 1, NOW()),
(18, 'Game Developer', 'Create game mechanics and logic.', 1, NOW()),
(19, 'Network Engineer', 'Design and monitor networks.', 1, NOW()),
(20, 'System Administrator', 'Maintain system uptime and security.', 1, NOW());


-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sender_id` int NOT NULL,
  `receiver_id` int NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `body` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `sender_id` (`sender_id`),
  KEY `receiver_id` (`receiver_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `bio` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `profile_pic` varchar(255) DEFAULT NULL,
  `confirmed` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `role`, `bio`, `created_at`, `profile_pic`, `confirmed`) VALUES
(1, 'JohnDoe', '0192023a7bbd73250516f069df18b500', 'john@example.com', 'user', 'Just a regular user.', '2025-07-24 12:00:00', NULL, 1),
(2, 'Jinu', '$2a$12$5to4CkEbNxM24VhlX8Qyle28HqSizsihfzMNBwEsHhrN8gLuONnsO', 'spider100@gmail.com', 'admin', 'admin', '2025-07-24 12:59:36', NULL, 1);


--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
