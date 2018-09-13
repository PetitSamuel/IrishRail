CREATE DATABASE irishrail;
CREATE TABLE `trains` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `status` char(1) DEFAULT NULL,
  `latitude` float DEFAULT NULL,
  `longitude` float DEFAULT NULL,
  `code` varchar(4) NOT NULL,
  `date` date NOT NULL,
  `message` varchar(45) DEFAULT NULL,
  `direction` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1