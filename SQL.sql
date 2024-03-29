-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               5.7.28-0ubuntu0.18.04.4 - (Ubuntu)
-- Операционная система:         Linux
-- HeidiSQL Версия:              10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Дамп структуры базы данных local.lc
CREATE DATABASE IF NOT EXISTS `local.lc` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `local.lc`;

-- Дамп структуры для таблица local.lc.messages
CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `room_id` int(10) NOT NULL DEFAULT '1',
  `message` text,
  `add_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_messages_user` (`user_id`),
  KEY `Индекс 3` (`room_id`),
  CONSTRAINT `FK_messages_room` FOREIGN KEY (`room_id`) REFERENCES `room` (`id`),
  CONSTRAINT `FK_messages_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=670 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы local.lc.messages: ~16 rows (приблизительно)
DELETE FROM `messages`;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
INSERT INTO `messages` (`id`, `user_id`, `room_id`, `message`, `add_time`) VALUES
	(567, 24, 1, 'ты дно я знал это', '2019-09-04 22:04:42'),
	(660, 24, 1, 'петя', '2019-12-01 02:03:15'),
	(662, 24, 5, 'ничего важного', '2019-12-01 10:38:53'),
	(663, 24, 1, 'ыф', '2019-12-01 11:03:35'),
	(664, 24, 3, 'фыфы', '2019-12-01 11:04:17'),
	(665, 24, 1, 'ыфы', '2019-12-01 11:04:23'),
	(666, 24, 1, 'йц', '2019-12-01 11:04:28'),
	(667, 24, 6, 'Политика', '2019-12-01 11:04:38'),
	(668, 24, 2, 'измененное сообщение', '2019-12-01 11:05:06'),
	(669, 24, 2, 'флуд флуд флуд флуд флуд', '2019-12-01 11:05:14');
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;

-- Дамп структуры для таблица local.lc.permission_room
CREATE TABLE IF NOT EXISTS `permission_room` (
  `user_id` int(11) DEFAULT NULL,
  `room_id` int(11) DEFAULT NULL,
  KEY `FK_permission_room_user` (`user_id`),
  KEY `FK_permission_room_room` (`room_id`),
  CONSTRAINT `FK_permission_room_room` FOREIGN KEY (`room_id`) REFERENCES `room` (`id`),
  CONSTRAINT `FK_permission_room_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы local.lc.permission_room: ~9 rows (приблизительно)
DELETE FROM `permission_room`;
/*!40000 ALTER TABLE `permission_room` DISABLE KEYS */;
INSERT INTO `permission_room` (`user_id`, `room_id`) VALUES
	(1, 1),
	(24, 1),
	(24, 2),
	(24, 3),
	(24, 7),
	(24, 5),
	(24, 6),
	(1, 7),
	(1, 6);
/*!40000 ALTER TABLE `permission_room` ENABLE KEYS */;

-- Дамп структуры для таблица local.lc.privilege
CREATE TABLE IF NOT EXISTS `privilege` (
  `id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы local.lc.privilege: ~5 rows (приблизительно)
DELETE FROM `privilege`;
/*!40000 ALTER TABLE `privilege` DISABLE KEYS */;
INSERT INTO `privilege` (`id`, `name`) VALUES
	(1, 'Guest'),
	(2, 'Banned User'),
	(3, 'User'),
	(5, 'Moderator'),
	(10, 'Administrator');
/*!40000 ALTER TABLE `privilege` ENABLE KEYS */;

-- Дамп структуры для таблица local.lc.privilege_roles
CREATE TABLE IF NOT EXISTS `privilege_roles` (
  `roles_id` int(10) NOT NULL,
  `privilege_id` int(10) NOT NULL,
  KEY `priv` (`privilege_id`),
  KEY `id_roles` (`roles_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы local.lc.privilege_roles: ~5 rows (приблизительно)
DELETE FROM `privilege_roles`;
/*!40000 ALTER TABLE `privilege_roles` DISABLE KEYS */;
INSERT INTO `privilege_roles` (`roles_id`, `privilege_id`) VALUES
	(3, 3),
	(3, 3),
	(3, 3),
	(555, 10),
	(2, 5);
/*!40000 ALTER TABLE `privilege_roles` ENABLE KEYS */;

-- Дамп структуры для таблица local.lc.room
CREATE TABLE IF NOT EXISTS `room` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name_room` varchar(50) DEFAULT '0',
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `Индекс 2` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы local.lc.room: ~7 rows (приблизительно)
DELETE FROM `room`;
/*!40000 ALTER TABLE `room` DISABLE KEYS */;
INSERT INTO `room` (`id`, `name_room`, `create_time`) VALUES
	(1, 'Основной', '2019-08-25 18:49:42'),
	(2, 'Флудилка', '2019-08-25 18:52:26'),
	(3, 'Модерка', '2019-08-25 14:30:08'),
	(4, 'пвп или зассал', '2019-08-25 18:53:13'),
	(5, 'Важное', '2019-09-07 00:24:48'),
	(6, 'Политика', '2019-09-07 00:25:22'),
	(7, '+18', '2019-09-07 00:25:37');
/*!40000 ALTER TABLE `room` ENABLE KEYS */;

-- Дамп структуры для таблица local.lc.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '0',
  `rol_id` int(10) NOT NULL DEFAULT '3',
  `password` varchar(255) NOT NULL DEFAULT '0',
  `user_email` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `Индекс 2` (`rol_id`),
  CONSTRAINT `FK_user_privilege` FOREIGN KEY (`rol_id`) REFERENCES `privilege` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы local.lc.user: ~5 rows (приблизительно)
DELETE FROM `user`;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `name`, `rol_id`, `password`, `user_email`) VALUES
	(1, '111', 2, 'f6e0a1e2ac41945a9aa7ff8a8aaa0cebc12a3bcc981a929ad5cf810a090e11ae', '1@1.com'),
	(24, 'Admin', 10, '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', '1@1.com'),
	(26, '222', 3, '9b871512327c09ce91dd649b3f96a63b7408ef267c8cc5710114e629730cb61f', '1@1.com'),
	(27, 'Вася', 3, 'f6e0a1e2ac41945a9aa7ff8a8aaa0cebc12a3bcc981a929ad5cf810a090e11ae', '1@1.com'),
	(65, '123', 3, 'f6e0a1e2ac41945a9aa7ff8a8aaa0cebc12a3bcc981a929ad5cf810a090e11ae', '123@123');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
