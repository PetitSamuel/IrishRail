CREATE DATABASE irishrail;
CREATE TABLE `trains` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `status` char(1) DEFAULT NULL,
  `latitude` float DEFAULT NULL,
  `longitude` float DEFAULT NULL,
  `code` varchar(4) NOT NULL,
  `date` varchar(40) NOT NULL,
  `message` text,
  `direction` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `code_index` (`code`),
  KEY `direction_index` (`direction`),
  KEY `date_index` (`date`),
  KEY `status_index` (`status`)
) ENGINE=MyISAM AUTO_INCREMENT=516 DEFAULT CHARSET=latin1;

CREATE TABLE `daily_recap` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `date` date DEFAULT NULL,
  `total_delay` int(11) DEFAULT '0',
  `on_time_trains` int(11) DEFAULT '0',
  `early_trains` int(11) DEFAULT '0',
  `late_trains` int(11) DEFAULT '0',
  `total_trains` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `date_index` (`date`),
  KEY `late_index` (`late_trains`),
  KEY `early_index` (`early_trains`),
  KEY `on_time_index` (`on_time_trains`),
  KEY `total_index` (`total_trains`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
