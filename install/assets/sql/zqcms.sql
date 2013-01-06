SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `zqcms`
--

-- --------------------------------------------------------

--
-- 表的结构 `zq_admin`
--

DROP TABLE IF EXISTS `zq_admin`;
CREATE TABLE IF NOT EXISTS `zq_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `passwd` varchar(255) NOT NULL,
  `email` varchar(64) NOT NULL,
  `logintime` int(10) NOT NULL,
  `loginip` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- 表的结构 `zq_articles`
--

DROP TABLE IF EXISTS `zq_articles`;
CREATE TABLE IF NOT EXISTS `zq_articles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `guid` varchar(64) NOT NULL,
  `typeid` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `shorttitle` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `writer` varchar(64) NOT NULL,
  `flag` set('c','h','p','f','s','j','a','b') NOT NULL,
  `color` char(7) NOT NULL,
  `source` char(30) NOT NULL,
  `click` int(11) NOT NULL,
  `rank` int(11) NOT NULL,
  `pubdate` int(11) NOT NULL,
  `senddate` int(11) NOT NULL,
  `lastpost` int(11) NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `goodpost` int(11) NOT NULL,
  `badpost` int(11) NOT NULL,
  `scores` int(11) NOT NULL,
  `scorecount` int(11) NOT NULL,
  `body` longtext NOT NULL,
  `redirecturl` varchar(255) NOT NULL,
  `thumb` varchar(255) NOT NULL,
  `external_links` varchar(255) NOT NULL,
  `game_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10046 ;

-- --------------------------------------------------------

--
-- 表的结构 `zq_companies`
--

DROP TABLE IF EXISTS `zq_companies`;
CREATE TABLE IF NOT EXISTS `zq_companies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `guid` varchar(64) NOT NULL,
  `typeid` int(11) NOT NULL,
  `short_name` varchar(64) NOT NULL,
  `full_name` varchar(128) NOT NULL,
  `description` varchar(255) NOT NULL,
  `flag` set('c','h','p','f','s','j','a','b') NOT NULL,
  `color` char(7) NOT NULL,
  `source` char(30) NOT NULL,
  `click` int(11) NOT NULL,
  `rank` int(11) NOT NULL,
  `pubdate` int(11) NOT NULL,
  `senddate` int(11) NOT NULL,
  `lastpost` int(11) NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `goodpost` int(11) NOT NULL,
  `badpost` int(11) NOT NULL,
  `scores` int(11) NOT NULL,
  `scorecount` int(11) NOT NULL,
  `data_type` int(11) NOT NULL,
  `offical_url` int(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `telephone` varchar(64) NOT NULL,
  `email` varchar(255) NOT NULL,
  `company_id` int(11) NOT NULL,
  `company_thumb` varchar(255) NOT NULL,
  `pinyin` char(64) NOT NULL,
  `game_count` int(11) NOT NULL DEFAULT '0',
  `kaifu_count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=401 ;

-- --------------------------------------------------------

--
-- 表的结构 `zq_galleries`
--

DROP TABLE IF EXISTS `zq_galleries`;
CREATE TABLE IF NOT EXISTS `zq_galleries` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `guid` varchar(64) NOT NULL,
  `typeid` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `shorttitle` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `writer` varchar(64) NOT NULL,
  `flag` set('c','h','p','f','s','j','a','b') NOT NULL,
  `color` char(7) NOT NULL,
  `source` char(30) NOT NULL,
  `click` int(11) NOT NULL,
  `rank` int(11) NOT NULL,
  `pubdate` int(11) NOT NULL,
  `senddate` int(11) NOT NULL,
  `lastpost` int(11) NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `goodpost` int(11) NOT NULL,
  `badpost` int(11) NOT NULL,
  `scores` int(11) NOT NULL,
  `scorecount` int(11) NOT NULL,
  `body` longtext NOT NULL,
  `redirecturl` varchar(255) NOT NULL,
  `thumb` varchar(255) NOT NULL,
  `external_links` varchar(255) NOT NULL,
  `game_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=249 ;

-- --------------------------------------------------------

--
-- 表的结构 `zq_games`
--

DROP TABLE IF EXISTS `zq_games`;
CREATE TABLE IF NOT EXISTS `zq_games` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `guid` varchar(64) NOT NULL,
  `typeid` int(11) NOT NULL,
  `game_name` varchar(255) NOT NULL,
  `shorttitle` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `flag` set('c','h','p','f','s','j','a','b') NOT NULL,
  `color` char(7) NOT NULL,
  `source` char(30) NOT NULL,
  `click` int(11) NOT NULL,
  `rank` int(11) NOT NULL,
  `pubdate` int(11) NOT NULL,
  `senddate` int(11) NOT NULL,
  `lastpost` int(11) NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `goodpost` int(11) NOT NULL,
  `badpost` int(11) NOT NULL,
  `scores` int(11) NOT NULL,
  `scorecount` int(11) NOT NULL,
  `game_tag` varchar(64) NOT NULL,
  `game_thumb` varchar(255) NOT NULL,
  `game_effect` varchar(32) NOT NULL,
  `game_theme` varchar(32) NOT NULL,
  `game_status` varchar(32) NOT NULL,
  `test_status` varchar(32) NOT NULL,
  `offical_url` varchar(255) NOT NULL,
  `oper_short_name` varchar(64) NOT NULL,
  `dev_short_name` varchar(64) NOT NULL,
  `pub_short_name` varchar(64) NOT NULL,
  `game_avatar` varchar(255) NOT NULL,
  `game_id` int(11) NOT NULL,
  `dev_id` int(11) NOT NULL,
  `pub_id` int(11) NOT NULL,
  `pinyin` char(32) NOT NULL,
  `kaifu_count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1722 ;

-- --------------------------------------------------------

--
-- 表的结构 `zq_game_company`
--

DROP TABLE IF EXISTS `zq_game_company`;
CREATE TABLE IF NOT EXISTS `zq_game_company` (
  `game_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `kaifu_count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`game_id`,`company_id`),
  KEY `game_id` (`game_id`),
  KEY `company_id` (`company_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `zq_game_info`
--

DROP TABLE IF EXISTS `zq_game_info`;
CREATE TABLE IF NOT EXISTS `zq_game_info` (
  `guid` varchar(32) NOT NULL,
  `title` varchar(64) NOT NULL,
  `value` text NOT NULL,
  `game_id` int(11) NOT NULL,
  PRIMARY KEY (`guid`),
  KEY `game_id` (`game_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `zq_gifts`
--

DROP TABLE IF EXISTS `zq_gifts`;
CREATE TABLE IF NOT EXISTS `zq_gifts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `guid` varchar(64) NOT NULL,
  `typeid` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `shorttitle` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `flag` set('c','h','p','f','s','j','a','b') NOT NULL,
  `color` char(7) NOT NULL,
  `source` varchar(30) NOT NULL,
  `click` int(11) NOT NULL,
  `rank` int(11) NOT NULL,
  `pubdate` int(11) NOT NULL,
  `senddate` int(11) NOT NULL,
  `lastpost` int(11) NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `goodpost` int(11) NOT NULL,
  `badpost` int(11) NOT NULL,
  `scores` int(11) NOT NULL,
  `scorecount` int(11) NOT NULL,
  `game_name` varchar(64) NOT NULL,
  `game_id` int(11) NOT NULL,
  `oper_short_name` varchar(64) NOT NULL,
  `send_date` int(11) NOT NULL,
  `get_url` varchar(255) NOT NULL,
  `gift_id` int(11) NOT NULL,
  `oper_id` int(11) NOT NULL,
  `server_name` varchar(64) NOT NULL,
  `gift_type` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1393 ;

-- --------------------------------------------------------

--
-- 表的结构 `zq_kaices`
--

DROP TABLE IF EXISTS `zq_kaices`;
CREATE TABLE IF NOT EXISTS `zq_kaices` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `guid` varchar(64) NOT NULL,
  `typeid` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `shorttitle` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `flag` set('c','h','p','f','s','j','a','b') NOT NULL,
  `color` char(7) NOT NULL,
  `source` varchar(30) NOT NULL,
  `click` int(11) NOT NULL,
  `rank` int(11) NOT NULL,
  `pubdate` int(11) NOT NULL,
  `senddate` int(11) NOT NULL,
  `lastpost` int(11) NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `goodpost` int(11) NOT NULL,
  `badpost` int(11) NOT NULL,
  `scores` int(11) NOT NULL,
  `scorecount` int(11) NOT NULL,
  `game_name` varchar(64) NOT NULL,
  `game_tag` varchar(64) NOT NULL,
  `game_id` int(11) NOT NULL,
  `oper_short_name` varchar(64) NOT NULL,
  `dev_short_name` varchar(64) NOT NULL,
  `server_name` varchar(64) NOT NULL,
  `test_date` int(11) NOT NULL,
  `register_url` varchar(255) NOT NULL,
  `data_type` tinyint(1) NOT NULL,
  `pub_short_name` varchar(64) NOT NULL,
  `test_status` varchar(64) NOT NULL,
  `get_url` varchar(255) NOT NULL,
  `bbs_url` varchar(255) NOT NULL,
  `gift_id` int(11) NOT NULL,
  `oper_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=246 ;

-- --------------------------------------------------------

--
-- 表的结构 `zq_kaifus`
--

DROP TABLE IF EXISTS `zq_kaifus`;
CREATE TABLE IF NOT EXISTS `zq_kaifus` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `guid` varchar(64) NOT NULL,
  `typeid` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `shorttitle` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `flag` set('c','h','p','f','s','j','a','b') NOT NULL,
  `color` char(7) NOT NULL,
  `source` varchar(30) NOT NULL,
  `click` int(11) NOT NULL,
  `rank` int(11) NOT NULL,
  `pubdate` int(11) NOT NULL,
  `senddate` int(11) NOT NULL,
  `lastpost` int(11) NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `goodpost` int(11) NOT NULL,
  `badpost` int(11) NOT NULL,
  `scores` int(11) NOT NULL,
  `scorecount` int(11) NOT NULL,
  `game_name` varchar(64) NOT NULL,
  `game_tag` varchar(64) NOT NULL,
  `game_id` int(11) NOT NULL,
  `oper_short_name` varchar(64) NOT NULL,
  `dev_short_name` varchar(64) NOT NULL,
  `server_name` varchar(64) NOT NULL,
  `test_date` int(11) NOT NULL,
  `register_url` varchar(255) NOT NULL,
  `data_type` tinyint(1) NOT NULL,
  `pub_short_name` varchar(64) NOT NULL,
  `gift_id` int(11) NOT NULL,
  `oper_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8835 ;

-- --------------------------------------------------------

--
-- 表的结构 `zq_members`
--

DROP TABLE IF EXISTS `zq_members`;
CREATE TABLE IF NOT EXISTS `zq_members` (
  `id` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `passwd` varchar(255) NOT NULL,
  `salt` char(4) NOT NULL,
  `email` varchar(255) NOT NULL,
  `sex` char(32) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `jointime` int(11) NOT NULL,
  `joinip` char(20) NOT NULL,
  `logintime` int(11) NOT NULL,
  `loginip` char(20) NOT NULL,
  `checkmail` tinyint(1) NOT NULL DEFAULT '-1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `zq_options`
--

DROP TABLE IF EXISTS `zq_options`;
CREATE TABLE IF NOT EXISTS `zq_options` (
  `id` smallint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `value` text NOT NULL,
  `description` varchar(100) NOT NULL,
  `type` tinyint(1) NOT NULL,
  `group` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

--
-- 表的结构 `zq_tags`
--

DROP TABLE IF EXISTS `zq_tags`;
CREATE TABLE IF NOT EXISTS `zq_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=46 ;

-- --------------------------------------------------------

--
-- 表的结构 `zq_tag_relationships`
--

DROP TABLE IF EXISTS `zq_tag_relationships`;
CREATE TABLE IF NOT EXISTS `zq_tag_relationships` (
  `aid` int(10) unsigned NOT NULL DEFAULT '0',
  `tag_taxonomy_id` int(10) unsigned NOT NULL DEFAULT '0',
  `typeid` int(11) unsigned NOT NULL,
  PRIMARY KEY (`aid`,`tag_taxonomy_id`,`typeid`),
  KEY `tag_taxonomy_id` (`tag_taxonomy_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `zq_tag_taxonomy`
--

DROP TABLE IF EXISTS `zq_tag_taxonomy`;
CREATE TABLE IF NOT EXISTS `zq_tag_taxonomy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tag_id` int(11) NOT NULL,
  `taxonomy` enum('tag','category') NOT NULL,
  `description` varchar(255) NOT NULL,
  `parent` int(11) NOT NULL,
  `count` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tag_id` (`tag_id`,`taxonomy`),
  KEY `taxonomy` (`taxonomy`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=54 ;

-- --------------------------------------------------------

--
-- 表的结构 `zq_types`
--

DROP TABLE IF EXISTS `zq_types`;
CREATE TABLE IF NOT EXISTS `zq_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `table_name` varchar(64) NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `ishidden` tinyint(1) NOT NULL DEFAULT '0',
  `order` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

INSERT INTO `zq_types` (`id`, `name`, `title`, `description`, `table_name`, `keywords`, `ishidden`, `order`) VALUES
(1, 'game', '游戏', '', 'games', '', 0, 1),
(2, 'kaifu', '开服表', '', 'kaifus', '', 0, 2),
(3, 'kaice', '开测表', '', 'kaices', '', 0, 2),
(4, 'gift', '礼包', '', 'gifts', '', 0, 0),
(5, 'article', '资讯', '', 'articles', '', 0, 3),
(6, 'company', '厂商列表', '', 'companies', '', 0, 0),
(7, 'gallery', '截图', '', 'galleries', '', 0, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
