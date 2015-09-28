SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `article`;
CREATE TABLE `article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `content` text COLLATE utf8_czech_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

INSERT INTO `article` (`id`, `title`, `content`, `url`, `created_at`) VALUES
  (1,	'Curabitur pretium pulvinar turpis',	'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam risus nunc, suscipit eu aliquet at, rutrum nec felis. Donec volutpat placerat varius. Phasellus nec enim ac risus gravida rutrum ut ac tortor. Fusce consequat lectus nec ante aliquam, quis elementum metus tincidunt. In in orci ligula. Fusce lacinia dapibus diam, eu mollis libero ultrices ac. Donec nunc lectus, viverra ut eros non, cursus ornare diam. Aenean semper volutpat accumsan.\n\nNunc aliquet mauris ut turpis luctus efficitur. In hac habitasse platea dictumst. Cras consequat sem faucibus, sodales erat id, vulputate nisl. Nam aliquam neque ac faucibus egestas. Nulla efficitur sapien nec nulla malesuada vulputate. Nulla facilisi. Suspendisse eget mi vel metus facilisis lobortis nec vel ipsum. Quisque dignissim viverra velit, non dapibus nisl pretium ut. Duis laoreet pellentesque nisi, tempor eleifend dui placerat eget. In pellentesque tristique mi et cursus. Vivamus a facilisis odio. Morbi et commodo lorem. Nullam at quam fringilla, luctus nisi ut, luctus augue. Vestibulum odio lacus, pulvinar in orci at, porta convallis turpis. Vestibulum lacinia fermentum ex, quis faucibus elit porttitor et.\n\nAliquam non varius sapien. Vivamus leo est, maximus sed nisi vel, pulvinar commodo urna. Duis ultrices pulvinar consectetur. Fusce hendrerit quam porta quam sodales, non tristique massa lacinia. Etiam sit amet enim non nunc placerat efficitur pharetra imperdiet ex. Vestibulum porta, ipsum id elementum tempus, lorem mi sodales ante, a dictum dolor nulla sit amet enim. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Nunc ac tempus augue. Donec mattis orci non metus euismod, id dapibus nisi pretium.\n\nSed quis mollis velit, vel lobortis enim. Donec imperdiet felis massa, quis finibus risus consectetur ut. Suspendisse placerat augue sit amet arcu dictum, ac pharetra velit varius. Quisque sollicitudin scelerisque tellus, at mollis magna condimentum nec. Ut ut pharetra lacus. Curabitur urna orci, vulputate et elit sed, mollis tristique ipsum. Integer consectetur magna vel felis gravida, eu sollicitudin ligula lobortis. Vestibulum lectus ligula, venenatis in dolor et, tempus cursus urna. Proin in lacus metus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer non tincidunt elit. Vestibulum sodales rutrum leo. Morbi nec ultrices nisi. Curabitur pretium pulvinar turpis, at varius ipsum rhoncus nec. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Ut dignissim erat eu velit commodo ultrices.\n\nAliquam sit amet quam sed diam aliquam facilisis nec id ligula. Quisque ac imperdiet justo. Integer bibendum nibh sed suscipit pharetra. Etiam non lorem nunc. Maecenas vitae felis felis. Nunc consequat est at dolor dignissim rhoncus. Vivamus eget sollicitudin lorem. Cras pretium vitae elit quis porttitor. Morbi egestas vestibulum erat, ut aliquam eros porta at. Integer ut lacinia magna, vel interdum mauris. Proin ac urna erat. In rutrum id urna pharetra cursus. Quisque in feugiat elit.',	'novy-blog',	'2015-02-27 10:53:04');

DROP TABLE IF EXISTS `article_in_category`;
CREATE TABLE `article_in_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  KEY `article_id` (`article_id`),
  CONSTRAINT `article_in_category_ibfk_5` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `article_in_category_ibfk_6` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

INSERT INTO `article_in_category` (`id`, `category_id`, `article_id`) VALUES
  (1,	1,	1);

DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

INSERT INTO `category` (`id`, `title`, `url`, `created_at`) VALUES
  (1,	'Lorem',	'lorem',	'2015-03-03 20:44:26'),
  (2,	'Ipsum',	'ipsum',	'2015-03-03 20:44:48');

DROP TABLE IF EXISTS `comment`;
CREATE TABLE `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `message` text COLLATE utf8_czech_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `article_id` (`article_id`),
  CONSTRAINT `comment_ibfk_6` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `comment_ibfk_7` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

INSERT INTO `comment` (`id`, `article_id`, `user_id`, `message`, `created_at`) VALUES
  (1,	1,	1,	'Etiam sit amet enim non nunc placerat efficitur pharetra imperdiet ex.',	'2015-03-03 18:08:17'),
  (4,	1,	3,	'Cras consequat sem faucibus, sodales erat id, vulputate nisl.',	'2015-03-03 18:54:45');

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `role` varchar(255) COLLATE utf8_czech_ci NOT NULL DEFAULT 'user',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

INSERT INTO `user` (`id`, `username`, `password`, `role`) VALUES
  (1,	'admin',	'$2y$10$pEMUJ/.qM1at5aoAF2eM9uKpUsa6Tz7QAXTHJ.jGas0Hkos0B6q8q',	'admin'),
  (3,	'test',	'$2y$10$lIox6HOHXM1zUemmG9h05uIcK3Y1GkXStnq4Wy6ZPnLd6UE/v0uMu',	'user');
