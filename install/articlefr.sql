--
-- Table structure for table `announcements`
--

CREATE TABLE IF NOT EXISTS `announcements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `article`
--

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

INSERT IGNORE INTO `badges` (`id`, `badge`, `points`) VALUES
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
  `name` varchar(255) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `parent` (`parent`),
  FULLTEXT KEY `fulltext` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=74 ;

--
-- Dumping data for table `category`
--

INSERT IGNORE INTO `category` (`name`, `id`, `parent`) VALUES
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
('Software', 69, 12),
('Free Classifieds', 70, 0),
('Wellness, Fitness and Diet', 73, 55);

-- --------------------------------------------------------

--
-- Table structure for table `channels`
--

CREATE TABLE IF NOT EXISTS `channels` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `logo_url` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `username` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `pid` bigint(20) NOT NULL,
  `type` varchar(255) COLLATE latin1_general_ci NOT NULL DEFAULT 'article',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `comment` text COLLATE latin1_general_ci NOT NULL,
  `checksum` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `penname` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `checksum` (`checksum`,`penname`),
  UNIQUE KEY `pid` (`pid`,`type`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `followers`
--

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

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE IF NOT EXISTS `friends` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user` bigint(20) NOT NULL,
  `friend` bigint(20) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `referrer` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=75 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Table structure for table `keywords`
--

CREATE TABLE IF NOT EXISTS `keywords` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=12 ;

--
-- Dumping data for table `links`
--

INSERT IGNORE INTO `links` (`id`, `title`, `url`, `rel`) VALUES
(1, 'Free Articles', 'http://www.isnare.com/', 'external'),
(2, 'Free Content', 'http://www.freecontentarticles.com', 'external'),
(4, 'All Women Central', 'http://allwomencentral.com', 'external'),
(5, 'Submitia', 'http://submitia.com', 'external'),
(7, 'Articles Archives', 'http://articles-archives.com', 'external'),
(9, 'iSnare Answers', 'https://www.isnare.org', 'external'),
(10, 'Contented Hosting', 'http://www.contentedhost.com', 'external'),
(11, 'Free Thumbnails', 'http://www.thumbgettys.com', 'external');

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

--
-- Table structure for table `media`
--

CREATE TABLE IF NOT EXISTS `media` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) DEFAULT NULL,
  `article` bigint(20) NOT NULL,
  `user` bigint(20) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `article` (`article`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Table structure for table `pages`
--

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Table structure for table `pingservers`
--

CREATE TABLE IF NOT EXISTS `pingservers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `url` (`url`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `pingservers`
--

INSERT IGNORE INTO `pingservers` (`id`, `url`) VALUES
(1, 'http://rpc.technorati.com/rpc/ping'),
(3, 'http://api.my.yahoo.com/RPC2'),
(4, 'http://blogupdate.org/ping/'),
(6, 'http://ping.feedburner.com'),
(7, 'http://ping.syndic8.com/xmlrpc.php'),
(8, 'http://ping.weblogalot.com/rpc.php'),
(10, 'http://rpc.weblogs.com/RPC2'),
(17, 'http://blogsearch.google.com/ping/RPC2'),
(15, 'http://ping.blogs.yandex.ru/RPC2');

--
-- Table structure for table `plugins`
--

CREATE TABLE IF NOT EXISTS `plugins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `site` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `active` int(11) NOT NULL DEFAULT '0',
  `path` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `latest` varchar(255) NOT NULL DEFAULT '1.0.0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `latest` (`latest`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `plugins`
--

INSERT IGNORE INTO `plugins` (`id`, `author`, `name`, `site`, `date`, `active`, `path`, `description`, `latest`) VALUES
(4, 'Glenn Prialde', 'Site Advertisements', 'http://freereprintables.com', '2014-09-04 21:03:39', 1, 'site_ads', 'Displays all ads in the site.', '1.0.0'),
(5, 'Glenn Prialde', 'XML Sitemaps', 'http://freereprintables.com', '2014-09-04 21:03:39', 1, 'xml_sitemap', 'Creates an XML Sitemap for your website.', '1.0.0'),
(6, 'Glenn Prialde', 'iSnare Answers', 'http://freereprintables.com', '2014-09-04 21:03:39', 1, 'isnare_answers', 'Display a page questions list from isnare.org.', '1.0.0'),
(8, 'Glenn Prialde', 'RSS', 'http://freereprintables.com', '2014-09-04 21:03:39', 1, 'rss', 'Creates an XML RSS (rss.xml) for your website.', '1.0.0');

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


--
-- Table structure for table `sessions`
--

CREATE TABLE IF NOT EXISTS `sessions` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `ip` varchar(15) NOT NULL DEFAULT '',
  `timestamp` varchar(15) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `settings`
--

INSERT IGNORE INTO `settings` (`id`, `name`, `content`, `date`) VALUES
(1, 'SITE_TITLE', 'Free Reprintables', '2014-01-10 20:20:18'),
(2, 'SITE_BRAND', '<img src="http://freereprintables.com/img/brand.png" border="0" alt="brand" width="190">', '2014-01-10 20:25:34'),
(3, 'SITE_FOOTER', 'Copyright &copy; <a href="http://freereprintables.com/">Free Reprintables</a> &mdash; All rights reserved world-wide.', '2014-01-11 00:12:59'),
(7, 'ADSENSE_PUBID', 'ca-pub-8542272527121315', '2014-01-19 21:35:31'),
(5, 'SITE_DESCRIPTION', 'An archives directory portal hosting quality free ezine articles content submitted by experts.', '2014-01-16 22:04:08'),
(8, 'AKISMET_KEY', 'c3460a3f1eed', '2014-01-23 03:33:59'),
(6, 'SITE_KEYWORDS', 'free articles, free ezine articles, ezine articles', '2014-01-16 22:05:29'),
(9, 'ARTICLE_MAX_WORDS', '3000', '2014-01-23 03:37:43'),
(10, 'ARTICLE_MIN_WORDS', '300', '2014-01-23 03:38:03'),
(11, 'TITLE_MAX_WORDS', '30', '2014-01-23 03:40:50'),
(12, 'TITLE_MIN_WORDS', '1', '2014-01-23 03:41:17'),
(13, 'ARTICLEFR_NETWORK_CONNECT', 'TRUE', '2014-07-05 06:39:11'),
(14, 'VIDEO_MAX_SUMARRY_WORDS', '150', '2014-08-16 07:44:06'),
(15, 'VIDEO_MIN_SUMARRY_WORDS', '50', '2014-08-16 07:44:06');

-- --------------------------------------------------------

--
-- Table structure for table `socials`
--

CREATE TABLE IF NOT EXISTS `socials` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `provider` varchar(255) NOT NULL,
  `signature` varchar(255) NOT NULL,
  `user` bigint(20) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `signature` (`signature`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `trackbacks`
--

CREATE TABLE IF NOT EXISTS `trackbacks` (
  `id` bigint(20) NOT NULL,
  `aid` bigint(20) NOT NULL,
  `url` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `summary` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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
  `isactive` set('active','inactive','deleted') NOT NULL DEFAULT 'inactive',
  `activekey` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`),
  KEY `isactive` (`isactive`),
  KEY `activekey` (`activekey`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

INSERT IGNORE INTO `users` (`id`, `username`, `password`, `email`, `membership`, `date`, `name`, `website`, `blog`, `points`, `isactive`, `activekey`) VALUES
(1, 'admin', 'admin123', 'admin@freereprintables.com', 'admin', '2014-01-17 07:46:40', 'Administrator', 'http://freereprintables.com', 'http://freereprintables.com', 100, 'active', NULL);

-- 
-- Table structure for table `videos`
--

CREATE TABLE IF NOT EXISTS `videos` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `channel` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `thumbnail` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `url` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `title` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `summary` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `views` int(11) NOT NULL DEFAULT '0',
  `likes` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`,`channel`),
  UNIQUE KEY `title_2` (`title`,`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `wall`
--

CREATE TABLE IF NOT EXISTS `wall` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `author` bigint(20) NOT NULL,
  `message` mediumtext NOT NULL,
  `date_posted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `checksum` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `checksum` (`checksum`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;