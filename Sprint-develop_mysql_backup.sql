-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.1.40-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             10.1.0.5464
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for sprint
CREATE DATABASE IF NOT EXISTS `sprint` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `sprint`;

-- Dumping structure for table sprint.airports
CREATE TABLE IF NOT EXISTS `airports` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT '',
  `code` varchar(255) DEFAULT '',
  `description` text,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `craeted_on` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Dumping data for table sprint.airports: ~1 rows (approximately)
/*!40000 ALTER TABLE `airports` DISABLE KEYS */;
INSERT INTO `airports` (`id`, `name`, `code`, `description`, `deleted`, `craeted_on`) VALUES
	(1, 'Southend', 'EGMC', 'An Airport', 0, '2020-11-17 18:33:59');
/*!40000 ALTER TABLE `airports` ENABLE KEYS */;

-- Dumping structure for table sprint.auth_groups
CREATE TABLE IF NOT EXISTS `auth_groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table sprint.auth_groups: ~0 rows (approximately)
/*!40000 ALTER TABLE `auth_groups` DISABLE KEYS */;
/*!40000 ALTER TABLE `auth_groups` ENABLE KEYS */;

-- Dumping structure for table sprint.auth_groups_permissions
CREATE TABLE IF NOT EXISTS `auth_groups_permissions` (
  `group_id` int(11) unsigned NOT NULL DEFAULT '0',
  `permission_id` int(11) unsigned NOT NULL DEFAULT '0',
  KEY `group_id_permission_id` (`group_id`,`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table sprint.auth_groups_permissions: ~0 rows (approximately)
/*!40000 ALTER TABLE `auth_groups_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `auth_groups_permissions` ENABLE KEYS */;

-- Dumping structure for table sprint.auth_groups_users
CREATE TABLE IF NOT EXISTS `auth_groups_users` (
  `group_id` int(11) unsigned NOT NULL DEFAULT '0',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0',
  KEY `group_id_user_id` (`group_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table sprint.auth_groups_users: ~0 rows (approximately)
/*!40000 ALTER TABLE `auth_groups_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `auth_groups_users` ENABLE KEYS */;

-- Dumping structure for table sprint.auth_logins
CREATE TABLE IF NOT EXISTS `auth_logins` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `ip_address` varchar(40) DEFAULT NULL,
  `datetime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

-- Dumping data for table sprint.auth_logins: ~27 rows (approximately)
/*!40000 ALTER TABLE `auth_logins` DISABLE KEYS */;
INSERT INTO `auth_logins` (`id`, `user_id`, `ip_address`, `datetime`) VALUES
	(1, 1, '::1', '2020-11-13 23:01:09'),
	(2, 3, '::1', '2020-11-14 20:07:21'),
	(3, 3, '::1', '2020-11-15 16:31:47'),
	(4, 3, '::1', '2020-11-15 16:40:40'),
	(5, 3, '::1', '2020-11-15 16:44:31'),
	(6, 3, '::1', '2020-11-15 16:44:50'),
	(7, 3, '::1', '2020-11-15 16:45:11'),
	(8, 3, '::1', '2020-11-15 16:45:27'),
	(9, 3, '::1', '2020-11-15 16:45:45'),
	(10, 3, '::1', '2020-11-15 16:47:12'),
	(11, 3, '::1', '2020-11-15 16:47:36'),
	(12, 4, '::1', '2020-11-15 18:04:35'),
	(13, 3, '::1', '2020-11-15 18:07:12'),
	(14, 3, '::1', '2020-11-15 18:07:38'),
	(15, 3, '::1', '2020-11-15 18:18:07'),
	(16, 3, '::1', '2020-11-15 18:31:30'),
	(17, 4, '::1', '2020-11-15 18:32:10'),
	(18, 4, '::1', '2020-11-15 18:33:11'),
	(19, 4, '::1', '2020-11-15 18:57:35'),
	(20, 4, '::1', '2020-11-15 19:13:01'),
	(21, 3, '::1', '2020-11-15 19:35:38'),
	(22, 3, '::1', '2020-11-15 22:10:31'),
	(23, 5, '::1', '2020-11-15 22:10:58'),
	(24, 3, '::1', '2020-11-15 22:17:17'),
	(25, 3, '::1', '2020-11-23 22:17:39'),
	(26, 3, '::1', '2020-12-01 20:30:56'),
	(27, 3, '::1', '2020-12-01 22:44:44');
/*!40000 ALTER TABLE `auth_logins` ENABLE KEYS */;

-- Dumping structure for table sprint.auth_login_attempts
CREATE TABLE IF NOT EXISTS `auth_login_attempts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(64) NOT NULL DEFAULT 'app',
  `ip_address` varchar(255) DEFAULT NULL,
  `user_id` int(11) unsigned DEFAULT NULL,
  `datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

-- Dumping data for table sprint.auth_login_attempts: ~9 rows (approximately)
/*!40000 ALTER TABLE `auth_login_attempts` DISABLE KEYS */;
INSERT INTO `auth_login_attempts` (`id`, `type`, `ip_address`, `user_id`, `datetime`) VALUES
	(1, 'app', NULL, NULL, '2020-11-13 22:57:49'),
	(4, 'app', NULL, NULL, '2020-11-13 22:58:53'),
	(6, 'user', NULL, 2, '2020-11-13 22:58:53'),
	(7, 'app', NULL, NULL, '2020-11-14 20:05:13'),
	(10, 'app', NULL, NULL, '2020-11-14 20:06:19'),
	(13, 'app', NULL, NULL, '2020-11-15 16:28:31'),
	(15, 'app', NULL, NULL, '2020-11-15 16:29:10'),
	(17, 'app', NULL, NULL, '2020-11-15 16:30:16'),
	(20, 'app', NULL, NULL, '2020-11-15 16:43:52');
/*!40000 ALTER TABLE `auth_login_attempts` ENABLE KEYS */;

-- Dumping structure for table sprint.auth_permissions
CREATE TABLE IF NOT EXISTS `auth_permissions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table sprint.auth_permissions: ~0 rows (approximately)
/*!40000 ALTER TABLE `auth_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `auth_permissions` ENABLE KEYS */;

-- Dumping structure for table sprint.auth_tokens
CREATE TABLE IF NOT EXISTS `auth_tokens` (
  `email` varchar(255) NOT NULL,
  `hash` char(40) NOT NULL,
  `created` datetime NOT NULL,
  KEY `email_hash` (`email`,`hash`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table sprint.auth_tokens: ~1 rows (approximately)
/*!40000 ALTER TABLE `auth_tokens` DISABLE KEYS */;
INSERT INTO `auth_tokens` (`email`, `hash`, `created`) VALUES
	('peterp@abc.com', '05366b44f105d33931b428cb882cff29bac2e9dc', '2020-11-15 18:31:30');
/*!40000 ALTER TABLE `auth_tokens` ENABLE KEYS */;

-- Dumping structure for table sprint.cars
CREATE TABLE IF NOT EXISTS `cars` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `make` varchar(100) DEFAULT '',
  `descr` text,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_on` datetime NOT NULL,
  `modified_on` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table sprint.cars: ~0 rows (approximately)
/*!40000 ALTER TABLE `cars` DISABLE KEYS */;
/*!40000 ALTER TABLE `cars` ENABLE KEYS */;

-- Dumping structure for table sprint.ci_sessions
CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  PRIMARY KEY (`id`,`ip_address`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table sprint.ci_sessions: ~0 rows (approximately)
/*!40000 ALTER TABLE `ci_sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `ci_sessions` ENABLE KEYS */;

-- Dumping structure for table sprint.cows
CREATE TABLE IF NOT EXISTS `cows` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT '',
  `descr` text,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_on` datetime NOT NULL,
  `rental` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Dumping data for table sprint.cows: ~4 rows (approximately)
/*!40000 ALTER TABLE `cows` DISABLE KEYS */;
INSERT INTO `cows` (`id`, `name`, `descr`, `deleted`, `created_on`, `rental`) VALUES
	(1, '', '', 0, '2020-11-21 10:36:16', NULL),
	(2, 'freesien', 'A black and white cow', 0, '2020-11-21 10:40:42', NULL),
	(3, 'ssdadsasd', 'sdasdadasdadd', 0, '2020-11-21 10:44:14', NULL),
	(4, 'fsffsdf', 'dfsffsfsfsfdssdsf', 0, '2020-11-21 10:47:25', NULL);
/*!40000 ALTER TABLE `cows` ENABLE KEYS */;

-- Dumping structure for table sprint.mail_queue
CREATE TABLE IF NOT EXISTS `mail_queue` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `mailer` varchar(255) NOT NULL,
  `params` text,
  `options` text,
  `sent` tinyint(1) NOT NULL DEFAULT '0',
  `sent_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sent` (`sent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table sprint.mail_queue: ~0 rows (approximately)
/*!40000 ALTER TABLE `mail_queue` DISABLE KEYS */;
/*!40000 ALTER TABLE `mail_queue` ENABLE KEYS */;

-- Dumping structure for table sprint.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `version` bigint(20) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `ondate` datetime NOT NULL,
  `latest_file_version` int(11) DEFAULT '0',
  KEY `alias` (`alias`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table sprint.migrations: ~4 rows (approximately)
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`version`, `alias`, `ondate`, `latest_file_version`) VALUES
	(20201116123544, 'mod:airports', '2020-11-16 18:57:15', 0),
	(20201119154304, 'mod:bobkmodule', '2020-11-19 15:46:25', 0),
	(20201121203040, 'mod:mycows', '2020-11-21 20:33:22', 0),
	(20201114191412, 'app', '2020-12-02 20:21:49', 0);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

-- Dumping structure for table sprint.posts
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT '',
  `body` text,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_on` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Dumping data for table sprint.posts: ~1 rows (approximately)
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` (`id`, `title`, `body`, `deleted`, `created_on`) VALUES
	(1, 'sdsdsdasd', 'sdadaasdada', 0, '2020-11-21 13:21:26');
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;

-- Dumping structure for table sprint.settings
CREATE TABLE IF NOT EXISTS `settings` (
  `name` varchar(255) NOT NULL,
  `value` varchar(255) DEFAULT NULL,
  `group` varchar(255) NOT NULL,
  PRIMARY KEY (`name`,`group`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table sprint.settings: ~0 rows (approximately)
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;

-- Dumping structure for table sprint.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `username` varchar(30) DEFAULT NULL,
  `password_hash` varchar(255) NOT NULL,
  `reset_hash` varchar(40) DEFAULT NULL,
  `activate_hash` varchar(40) DEFAULT NULL,
  `created_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` varchar(255) DEFAULT NULL,
  `status_message` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `force_pass_reset` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- Dumping data for table sprint.users: ~5 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `email`, `username`, `password_hash`, `reset_hash`, `activate_hash`, `created_on`, `status`, `status_message`, `active`, `deleted`, `force_pass_reset`) VALUES
	(1, 'bobkendrick90@gmail.com', 'bobk', '$2y$10$adNXDGd9WQ.fsw.AgdiB0eSeJZYHLR0l7TBmljmWN7zVn285mTCY.', NULL, '4af47242a109465aa96db2dff297fb3540fde61b', '2020-11-13 20:59:11', NULL, NULL, 1, 0, 0),
	(2, 'fredkendrick90@gmail.com', 'gdfgdgdgg', '$2y$10$GQ3HEVDoS72Z/jLyTvIhx.x8oi4Lr2v7TxcyIKtYocdKwNB4fhFQm', NULL, '4ffa895987b30c199da80a3971faaace7e1dfa10', '2020-11-13 22:23:47', NULL, NULL, 1, 0, 0),
	(3, 'peterp@abc.com', 'peterp', '$2y$10$SMShhygpGdZA8RPQXwiSae.gK4M34B5xkbyIBql5wLRJb36W6M9nm', NULL, '68d6ac7d61b531f6651053ee5ef3a1dc41a1ec36', '2020-11-14 20:04:39', NULL, NULL, 1, 0, 0),
	(4, 'davidd@abc.com', 'davidd', '$2y$10$wCchryZVBMjpvALQOLuzbuK1iZ0lrDgSsso0AD6DPaufpIuZ1RixG', NULL, '25425df094b7492ff3b22a016e7de61cf0be8e57', '2020-11-15 16:49:44', NULL, NULL, 1, 0, 0),
	(5, 'larryl@abc.com', 'larryl', '$2y$10$JFu9Bv2H.YUdxyyCxIgMUOrwjyvW7uhnAaUZxYqwi2Gw4TZkglMc2', NULL, '0203325d72074d7016ccaf6a7bc7199836ce2848', '2020-11-15 22:10:20', NULL, NULL, 1, 0, 0);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

-- Dumping structure for table sprint.user_meta
CREATE TABLE IF NOT EXISTS `user_meta` (
  `user_id` int(11) unsigned NOT NULL,
  `meta_key` varchar(255) NOT NULL,
  `meta_value` text,
  PRIMARY KEY (`user_id`,`meta_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table sprint.user_meta: ~10 rows (approximately)
/*!40000 ALTER TABLE `user_meta` DISABLE KEYS */;
INSERT INTO `user_meta` (`user_id`, `meta_key`, `meta_value`) VALUES
	(1, 'first_name', 'Bob'),
	(1, 'last_name', 'Kendrick'),
	(2, 'first_name', 'Bob'),
	(2, 'last_name', 'Kendrick'),
	(3, 'first_name', 'Peter'),
	(3, 'last_name', 'Piper'),
	(4, 'first_name', 'David'),
	(4, 'last_name', 'Dopey'),
	(5, 'first_name', 'Larry'),
	(5, 'last_name', 'Lamb');
/*!40000 ALTER TABLE `user_meta` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
