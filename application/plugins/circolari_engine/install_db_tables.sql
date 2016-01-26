CREATE TABLE IF NOT EXISTS `plugin_circolari_engine_articles` (
  `id` varchar(13) NOT NULL,
  `category` varchar(32) NOT NULL,
  `number` smallint(6) NOT NULL,
  `suffix` varchar(16) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;