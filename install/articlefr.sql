--
-- Table structure for table `article`
--
DROP TABLE IF EXISTS `article`;
DROP TABLE IF EXISTS `badges`;
DROP TABLE IF EXISTS `category`;
DROP TABLE IF EXISTS `follow`;
DROP TABLE IF EXISTS `inbox`;
DROP TABLE IF EXISTS `keyword`;
DROP TABLE IF EXISTS `links`;
DROP TABLE IF EXISTS `log`;
DROP TABLE IF EXISTS `network`;
DROP TABLE IF EXISTS `penname`;
DROP TABLE IF EXISTS `rating`;
DROP TABLE IF EXISTS `settings`;
DROP TABLE IF EXISTS `users`;

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
  FULLTEXT KEY `summary` (`summary`,`body`,`title`),
  FULLTEXT KEY `about` (`about`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `badges`
--

CREATE TABLE IF NOT EXISTS `badges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `badge` varchar(255) NOT NULL,
  `points` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `badges`
--

INSERT INTO `badges` (`id`, `badge`, `points`) VALUES
(1, 'Writer', 100),
(2, 'Synonymizer', 200),
(3, 'Organizer', 500),
(4, 'Proofreader', 1000),
(5, 'Teacher', 1500),
(6, 'Guru', 2000),
(7, 'Scholar', 300);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `name` varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `parent` (`parent`),
  FULLTEXT KEY `fulltext` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=57 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`name`, `id`, `parent`) VALUES
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
('Death', 16, 0),
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
('General', 56, 0);
-- --------------------------------------------------------

--
-- Table structure for table `follow`
--

CREATE TABLE IF NOT EXISTS `follow` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user` varchar(255) NOT NULL,
  `follower` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `inbox`
--

CREATE TABLE IF NOT EXISTS `inbox` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `to` varchar(255) NOT NULL,
  `from` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `keyword`
--

CREATE TABLE IF NOT EXISTS `keyword` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `aid` bigint(20) NOT NULL,
  `term` varchar(255) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `aid` (`aid`,`term`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `links`
--

CREATE TABLE IF NOT EXISTS `links` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `url` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `rel` varchar(255) COLLATE latin1_general_ci NOT NULL DEFAULT 'external',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `links`
--

INSERT INTO `links` (`id`, `title`, `url`, `rel`) VALUES
(1, 'Free Articles', 'http://www.isnare.com/', 'external'),
(2, 'Free Articles and Quotes', 'http://www.freecontentarticles.com', 'external'),
(4, 'All Women Central', 'http://allwomencentral.com', 'external'),
(5, 'Submitia', 'http://submitia.com', 'external'),
(6, 'Free Ezine Articles', 'http://free-ezine-articles.com', 'external');

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE IF NOT EXISTS `log` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `value` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `article` int(11) NOT NULL DEFAULT '0',
  `user` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `network`
--

CREATE TABLE IF NOT EXISTS `network` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user` bigint(20) NOT NULL,
  `friend` bigint(20) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `penname`
--

CREATE TABLE IF NOT EXISTS `penname` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `name` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `biography` text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `gravatar` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

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

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `content` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `name`, `content`, `date`) VALUES
(1, 'SITE_TITLE', 'Free Articles Archives', '2014-01-11 04:20:18'),
(2, 'SITE_BRAND', 'Free Articles Archives', '2014-01-11 04:25:34'),
(3, 'SITE_FOOTER', 'Copyright &copy; <a href="http://http://articles-archives.com/">Articles Archives</a> &mdash; All rights reserved world-wide.', '2014-01-11 08:12:59'),
(7, 'ADSENSE_PUBID', 'ca-pub-8542272527121315', '2014-01-20 05:35:31'),
(5, 'SITE_DESCRIPTION', 'An archives directory portal hosting quality free ezine articles content submitted by experts.', '2014-01-17 06:04:08'),
(8, 'AKISMET_KEY', 'c3460a3f1eed', '2014-01-23 11:33:59'),
(6, 'SITE_KEYWORDS', 'free articles, free ezine articles, ezine articles', '2014-01-17 06:05:29'),
(9, 'ARTICLE_MAX_WORDS', '3000', '2014-01-23 11:37:43'),
(10, 'ARTICLE_MIN_WORDS', '300', '2014-01-23 11:38:03'),
(11, 'TITLE_MAX_WORDS', '30', '2014-01-23 11:40:50'),
(12, 'TITLE_MIN_WORDS', '1', '2014-01-23 11:41:17');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

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
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`,`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

INSERT INTO `users` (`id`, `username`, `password`, `email`, `membership`, `date`, `name`, `website`, `blog`, `points`) VALUES (1, 'admin', 'admin123', 'admin@testdomain.com', 'admin', '2014-01-17 15:46:40', 'Administrator Account', NULL, NULL, 100);