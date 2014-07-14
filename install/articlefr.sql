DROP TABLE IF EXISTS `article`;
CREATE TABLE IF NOT EXISTS `article` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `summary` text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `body` text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `author` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `title` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `category` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `about` text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL DEFAULT '0',
  `views` int(11) NOT NULL DEFAULT '0',
  `checksum` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`),
  KEY `username` (`username`),
  FULLTEXT KEY `summary` (`summary`,`body`,`title`),
  FULLTEXT KEY `about` (`about`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `badges`;
CREATE TABLE IF NOT EXISTS `badges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `badge` varchar(255) NOT NULL,
  `points` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;


REPLACE INTO `badges` (`id`, `badge`, `points`) VALUES
(1, 'Writer', 100),
(2, 'Synonymizer', 200),
(3, 'Organizer', 500),
(4, 'Proofreader', 1000),
(5, 'Teacher', 1500),
(6, 'Guru', 2000),
(7, 'Scholar', 300);


DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `name` varchar(255) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `parent` (`parent`),
  FULLTEXT KEY `fulltext` (`name`),
  FULLTEXT KEY `name_2` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=70 ;


REPLACE INTO `category` (`name`, `id`, `parent`) VALUES
('Aging', 2, 0),
('Arts and Crafts', 3, 0),
('Automotive', 4, 0),
('Break-up', 5, 0),
('Business', 6, 0),
('Business Management', 7, 0),
('Career', 9, 0),
('Computers and Technology', 12, 0),
('Cooking', 13, 0),
('Culture', 14, 0),
('Dating', 15, 0),
('Education', 17, 0),
('Entertainment', 18, 0),
('Etiquette', 19, 0),
('Family Concerns', 20, 0),
('Fashion', 21, 0),
('Finances', 22, 0),
('Food and Drinks', 23, 0),
('Gardening', 24, 0),
('Home Management', 25, 0),
('Humor', 26, 0),
('Internet', 27, 0),
('Jobs', 28, 0),
('Leadership', 29, 0),
('Legal', 30, 0),
('Marketing', 31, 0),
('Marriage', 32, 0),
('Medical Business', 33, 0),
('Medicines and Remedies', 34, 0),
('Opinions', 35, 0),
('Parenting', 36, 0),
('Pets', 37, 0),
('Poetry', 38, 0),
('Politics', 39, 0),
('Real Estate', 40, 0),
('Recreation', 41, 0),
('Relationships', 42, 0),
('Religion', 43, 0),
('Self Help', 44, 0),
('Shopping', 46, 0),
('Society', 48, 0),
('Sports', 49, 0),
('Travel', 50, 0),
('Womens Interest', 52, 0),
('World Affairs', 53, 0),
('Writing', 54, 0),
('Health', 55, 0),
('General', 59, 0),
('Speaking', 60, 0),
('Robotics', 61, 0),
('Hardware', 68, 12),
('Press Release', 64, 0),
('Martial Arts', 65, 0),
('Lifestyle', 67, 0),
('Software', 69, 12);

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `article` bigint(20) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `comment` text COLLATE latin1_general_ci NOT NULL,
  `checksum` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `penname` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `checksum` (`checksum`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;


DROP TABLE IF EXISTS `followers`;
CREATE TABLE IF NOT EXISTS `followers` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `segment_id` bigint(20) unsigned NOT NULL,
  `segment_type` set('category','author') NOT NULL DEFAULT 'category',
  `email` varchar(255) NOT NULL,
  `activation` varchar(255) NOT NULL,
  `active` int(11) NOT NULL DEFAULT '0',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `segment_id` (`segment_id`),
  KEY `name` (`activation`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


DROP TABLE IF EXISTS `inbox`;
CREATE TABLE IF NOT EXISTS `inbox` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `to` varchar(255) NOT NULL,
  `from` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


DROP TABLE IF EXISTS `keywords`;
CREATE TABLE IF NOT EXISTS `keywords` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `aid` bigint(20) NOT NULL,
  `term` varchar(255) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `aid` (`aid`,`term`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;


DROP TABLE IF EXISTS `links`;
CREATE TABLE IF NOT EXISTS `links` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `url` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `rel` varchar(255) COLLATE latin1_general_ci NOT NULL DEFAULT 'external',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=10 ;


REPLACE INTO `links` (`id`, `title`, `url`, `rel`) VALUES
(1, 'Free Articles', 'http://www.isnare.com/', 'external'),
(2, 'Free Articles and Quotes', 'http://www.freecontentarticles.com', 'external'),
(4, 'All Women Central', 'http://allwomencentral.com', 'external'),
(5, 'Submitia', 'http://submitia.com', 'external'),
(6, 'Free Ezine Articles', 'http://free-ezine-articles.com', 'external'),
(7, 'Articles Archives', 'http://articles-archives.com', 'external'),
(9, 'iSnare Answers', 'https://www.isnare.org', 'external');

DROP TABLE IF EXISTS `log`;
CREATE TABLE IF NOT EXISTS `log` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `value` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `article` int(11) NOT NULL DEFAULT '0',
  `user` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `pages`;
CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `content` text,
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`,`description`),
  UNIQUE KEY `url` (`url`),
  KEY `status` (`status`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

INSERT INTO `pages` (`id`, `url`, `title`, `description`, `keywords`, `content`, `status`) VALUES 
(6, 'about', 'About Us', 'About ArticleFR and Free Reprintables website...', 'articlefr,free reprintables,free articles,free article directory', '<h2><span>About Us<br></span></h2><p>Welcome to articleFR''s page of freereprintables.com. What is articleFR? Well, articleFR is an open source Article Directory System developed by iSnare Online Technologies with Glenn Prialde as its author. It is a web application written to cater the needs of rapid creation of Article Directories.</p><p>Technically, articleFR is written in PHP+MySQL and is tested to be hold millions of data and still functions normally being lightweight and customizable with its plugins supported framework.</p>', 1);

DROP TABLE IF EXISTS `penname`;
CREATE TABLE IF NOT EXISTS `penname` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `name` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `biography` text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `gravatar` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `plugins`;
CREATE TABLE IF NOT EXISTS `plugins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `site` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `active` int(11) NOT NULL DEFAULT '0',
  `path` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

REPLACE INTO `plugins` (`id`, `author`, `name`, `site`, `date`, `active`, `path`, `description`) VALUES
(1, 'Glenn Prialde', 'Hello World', 'http://freereprintables.com', '2014-07-08 12:42:06', 0, 'hello_world', 'Replaces all SITE_TITLE as "Hello World".');

DROP TABLE IF EXISTS `rating`;
CREATE TABLE IF NOT EXISTS `rating` (
  `id` bigint(20) NOT NULL,
  `rate` bigint(20) NOT NULL,
  `votes` bigint(20) NOT NULL,
  `up` bigint(20) NOT NULL DEFAULT '0',
  `down` bigint(20) NOT NULL DEFAULT '0',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `rate` (`rate`,`date`),
  KEY `votes` (`votes`),
  KEY `up` (`up`,`down`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `content` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `ip` varchar(15) NOT NULL DEFAULT '',
  `timestamp` varchar(15) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

REPLACE INTO `settings` (`id`, `name`, `content`, `date`) VALUES
(1, 'SITE_TITLE', 'Free Reprintables', '2014-01-10 20:20:18'),
(2, 'SITE_BRAND', '<img src="http://freereprintables.com/img/brand.png" border="0" alt="brand" height="40" width="200">', '2014-01-10 20:25:34'),
(3, 'SITE_FOOTER', 'Copyright &copy; <a href="http://freereprintables.com/">Free Reprintables</a> &mdash; All rights reserved world-wide.', '2014-01-11 00:12:59'),
(7, 'ADSENSE_PUBID', 'ca-pub-8542272527121315', '2014-01-19 21:35:31'),
(5, 'SITE_DESCRIPTION', 'An archives directory portal hosting quality free ezine articles content submitted by experts.', '2014-01-16 22:04:08'),
(8, 'AKISMET_KEY', 'c3460a3f1eed', '2014-01-23 03:33:59'),
(6, 'SITE_KEYWORDS', 'free articles, free ezine articles, ezine articles', '2014-01-16 22:05:29'),
(9, 'ARTICLE_MAX_WORDS', '3000', '2014-01-23 03:37:43'),
(10, 'ARTICLE_MIN_WORDS', '300', '2014-01-23 03:38:03'),
(11, 'TITLE_MAX_WORDS', '30', '2014-01-23 03:40:50'),
(12, 'TITLE_MIN_WORDS', '1', '2014-01-23 03:41:17'),
(13, 'ARTICLEFR_NETWORK_CONNECT', 'FALSE', '2014-07-05 06:39:11');

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `email` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `membership` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT 'normal',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `name` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `website` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `blog` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `points` int(11) NOT NULL DEFAULT '100',
  `isactive` set('active','inactive') NOT NULL DEFAULT 'inactive',
  `activekey` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`),
  KEY `isactive` (`isactive`),
  KEY `activekey` (`activekey`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

REPLACE INTO `users` (`id`, `username`, `password`, `email`, `membership`, `date`, `name`, `website`, `blog`, `points`, `isactive`, `activekey`) VALUES
(1, 'admin', 'admin123', 'admin@testdomain.com', 'admin', '2014-01-17 07:46:40', 'Administrator', 'http://www.example.com', 'http://www.example.org/', 100, 'active', NULL);