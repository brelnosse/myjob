-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           8.0.30 - MySQL Community Server - GPL
-- SE du serveur:                Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour myjob
CREATE DATABASE IF NOT EXISTS `myjob` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `myjob`;

-- Listage de la structure de table myjob. abonne
CREATE TABLE IF NOT EXISTS `abonne` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `montant` float DEFAULT NULL,
  `num_tel` bigint DEFAULT NULL,
  `date_debut_abnmt` date DEFAULT NULL,
  `date_fin_abnmt` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table myjob.abonne : ~2 rows (environ)
INSERT INTO `abonne` (`id`, `user_id`, `montant`, `num_tel`, `date_debut_abnmt`, `date_fin_abnmt`) VALUES
	(15, 15, 1000, 650194960, '2024-12-17', '2025-01-17'),
	(16, 16, 1000, 676144352, '2024-12-17', '2025-01-17'),
	(17, 19, 1000, 673809889, '2024-12-18', '2025-01-18');

-- Listage de la structure de table myjob. commentaire
CREATE TABLE IF NOT EXISTS `commentaire` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `guest_id` int DEFAULT NULL,
  `post_id` int DEFAULT NULL,
  `msg` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table myjob.commentaire : ~7 rows (environ)
INSERT INTO `commentaire` (`id`, `user_id`, `guest_id`, `post_id`, `msg`) VALUES
	(5, 15, 16, 2, 'bonjour'),
	(6, 15, 16, 2, 'cool'),
	(7, 15, 16, 2, 'hi'),
	(8, 15, 7, 1, 'hi'),
	(9, 15, 17, 2, 'HI'),
	(10, 19, 20, 4, 'bonjour'),
	(11, 19, 20, 4, 'slt');

-- Listage de la structure de table myjob. contact
CREATE TABLE IF NOT EXISTS `contact` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `receiver_id` int DEFAULT NULL,
  `last_talk` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table myjob.contact : ~0 rows (environ)
INSERT INTO `contact` (`id`, `user_id`, `receiver_id`, `last_talk`) VALUES
	(9, 19, 19, '2024-12-18 10:24:13'),
	(10, 20, 19, '2024-12-19 13:24:47');

-- Listage de la structure de table myjob. likeposts
CREATE TABLE IF NOT EXISTS `likeposts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `guest_id` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table myjob.likeposts : ~4 rows (environ)
INSERT INTO `likeposts` (`id`, `user_id`, `guest_id`) VALUES
	(3, 15, 17),
	(11, 1, 7),
	(12, 2, 17),
	(13, 4, 19),
	(14, 1, 15);

-- Listage de la structure de table myjob. likes
CREATE TABLE IF NOT EXISTS `likes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `guest_id` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table myjob.likes : ~1 rows (environ)
INSERT INTO `likes` (`id`, `user_id`, `guest_id`) VALUES
	(3, 16, 16),
	(7, 16, 19),
	(8, 15, 20);

-- Listage de la structure de table myjob. message
CREATE TABLE IF NOT EXISTS `message` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `receiver_id` int DEFAULT NULL,
  `message` varchar(50) DEFAULT NULL,
  `date_env` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table myjob.message : ~8 rows (environ)
INSERT INTO `message` (`id`, `user_id`, `receiver_id`, `message`, `date_env`) VALUES
	(6, 17, 15, 'bonjour', '2024-12-18 06:31:02'),
	(7, 17, 15, 'hello', '2024-12-18 06:31:08'),
	(8, 17, 15, 'hello', '2024-12-18 06:31:46'),
	(9, 17, 15, 'hello', '2024-12-18 06:33:33'),
	(10, 17, 15, 'hello', '2024-12-18 06:34:15'),
	(11, 17, 15, 'hello', '2024-12-18 06:36:05'),
	(12, 16, 15, 'bonjour', '2024-12-18 06:41:16'),
	(13, 15, 16, 'HELLO', '2024-12-18 07:09:19'),
	(14, 7, 15, 'gfujhk\r\n', '2024-12-18 08:04:27'),
	(15, 18, 15, 'ghh', '2024-12-18 08:23:32'),
	(16, 20, 19, 'hi', '2024-12-19 13:21:33');

-- Listage de la structure de table myjob. post
CREATE TABLE IF NOT EXISTS `post` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `msg` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `pic1` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `pic2` varchar(100) DEFAULT NULL,
  `pic3` varchar(100) DEFAULT NULL,
  `pic4` varchar(100) DEFAULT NULL,
  `date_post` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table myjob.post : ~4 rows (environ)
INSERT INTO `post` (`id`, `user_id`, `msg`, `pic1`, `pic2`, `pic3`, `pic4`, `date_post`) VALUES
	(1, 15, 'bonjour', '', '', '', '', '2024-12-17'),
	(2, 15, 'bonjour le monde', '', '../resources/img/0c909d63-a819-4624-af40-5bc723b96a75.jpg', '', '', '2024-12-17'),
	(3, 15, 'hello', '', '', '', '', '2024-12-18'),
	(4, 19, 'bonnjour', '../resources/img/4608053_1.jpg', '../resources/img/0c909d63-a819-4624-af40-5bc723b96a75.jpg', '../resources/img/d500f88d-b5b0-42b3-ac8b-d286ea264b7ecreer_publier_ad1355726479.jpeg', '../resources/img/0c909d63-a819-4624-af40-5bc723b96a75.jpg', '2024-12-18');

-- Listage de la structure de table myjob. users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `prenom` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `filiere` enum('BTS','TI','PREP 3IL') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `niveau` enum('1','2') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `telephone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `photo_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Listage des données de la table myjob.users : ~7 rows (environ)
INSERT INTO `users` (`id`, `nom`, `prenom`, `filiere`, `niveau`, `email`, `telephone`, `password`, `photo_path`, `created_at`) VALUES
	(39, 'nosse', 'brel', 'PREP 3IL', '1', 'brelnosse2@gmail.com', '654587412', 'bonjour', '39_1732630055.png', '2024-11-26 14:07:20'),
	(41, 'Brandon', 'john', 'TI', '2', 'brelnosse@gmail.com', '654587412', 'bonjour', '41_1732726621.jpg', '2024-11-27 16:56:47'),
	(42, 'Megouya ', 'Inès ', 'TI', '2', 'rabioltadjuichi@gmail.com', '657156118', 'ines', '42_1733131358.jpg', '2024-12-02 09:21:48'),
	(43, 'tonfack', 'patrice', 'PREP 3IL', '2', 'tonfack@gmail.com', '650194352', 'bonsoir', '43_1733232265.png', '2024-12-03 13:14:03'),
	(44, 'ktrjhptrmmep', 'iorihij;lds', 'BTS', '1', 'wsfyygfxd@gmil.com', '678495623', '1234', '', '2024-12-03 17:20:40'),
	(45, 'tufgj', 'jjnk', 'PREP 3IL', '2', 'cxghijljgdr@gmil.com', '678495642', '1234', '45_1733246552.png', '2024-12-03 17:21:57'),
	(47, 'Djoumessi', 'Brandon', 'PREP 3IL', '2', 'djoumessiivan2006@gmail.com', '676724719', 'bonjoure', '47_1733254100.jpg', '2024-12-03 19:25:31');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
