
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

CREATE TABLE IF NOT EXISTS `token` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `token` varchar(64) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

ALTER TABLE  `user` ADD  `status` TINYINT UNSIGNED NOT NULL;

ALTER TABLE  `user` CHANGE  `last_login`  `last_login` DATETIME NULL DEFAULT NULL;

ALTER TABLE  `user` CHANGE  `last_login_ip`  `last_login_ip` VARCHAR( 45 ) NULL DEFAULT NULL;
