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
  `offical_url` varchar(255) NOT NULL,
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
-- 表的结构 `zq_links`
--

DROP TABLE IF EXISTS `zq_links`;
CREATE TABLE IF NOT EXISTS `zq_links` (
  `linkid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `linktype` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `name` varchar(50) NOT NULL DEFAULT '',
  `url` varchar(255) NOT NULL DEFAULT '',
  `logo` varchar(255) NOT NULL DEFAULT '',
  `introduce` text NOT NULL,
  `listorder` smallint(5) unsigned NOT NULL DEFAULT '0',
  `elite` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `passed` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`linkid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

INSERT INTO `zq_links` (`linkid`, `linktype`, `name`, `url`, `logo`, `introduce`, `listorder`, `elite`, `passed`, `addtime`) VALUES
(1, 0, 'ZQCMS 官方网站', 'http://www.zqcms.com', '', 'ZQCMS 程序官方网站', 99, 1, 1, 1361172740);

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
-- 表的结构 `zq_poster`
--

DROP TABLE IF EXISTS `zq_poster`;
CREATE TABLE IF NOT EXISTS `zq_poster` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `sign` varchar(40) NOT NULL,
  `name` varchar(40) NOT NULL,
  `content` text NOT NULL,
  `default` text NOT NULL,
  `startdate` int(10) unsigned NOT NULL DEFAULT '0',
  `enddate` int(10) unsigned NOT NULL DEFAULT '0',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `hits` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `clicks` smallint(5) unsigned NOT NULL DEFAULT '0',
  `listorder` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `disabled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

INSERT INTO `zq_poster` (`id`, `sign`, `name`, `content`, `default`, `startdate`, `enddate`, `addtime`, `hits`, `clicks`, `listorder`, `disabled`) VALUES
(1, 'topBackground', '页面背景图广告', '<script src=\\''http://cdn.img.dbplay.com/userfiles/poster/topBackground.js\\'' language=\\''javascript\\''></script>', '<script src=\\''http://cdn.img.dbplay.com/userfiles/poster/topBackground.js\\'' language=\\''javascript\\''></script>', 1352347292, 1361344093, 1361344093, 0, 0, 0, 0),
(2, 'navGameRecom', '顶部导航下游戏推荐', '<script src=\\''http://cdn.img.dbplay.com/userfiles/poster/navGameRecom.js\\'' language=\\''javascript\\''></script>', '<script src=\\''http://cdn.img.dbplay.com/userfiles/poster/navGameRecom.js\\'' language=\\''javascript\\''></script>', 1352347292, 1353574318, 1361344309, 0, 0, 0, 1),
(3, 'gameBannerLeft', '找游戏分栏广告(左)', '<script src=\\''http://cdn.img.dbplay.com/userfiles/poster/gameBannerLeft.js\\'' language=\\''javascript\\''></script>', '<script src=\\''http://cdn.img.dbplay.com/userfiles/poster/gameBannerLeft.js\\'' language=\\''javascript\\''></script>', 1352347292, 1353574318, 1361344396, 0, 0, 0, 0),
(4, 'gameBannerMiddle', '找游戏分栏广告(中)', '<script src=\\''http://cdn.img.dbplay.com/userfiles/poster/gameBannerMiddle.js\\'' language=\\''javascript\\''></script>', '<script src=\\''http://cdn.img.dbplay.com/userfiles/poster/gameBannerMiddle.js\\'' language=\\''javascript\\''></script>', 1352347292, 1353574318, 1361344443, 0, 0, 0, 0),
(5, 'gameBannerRight', '找游戏分栏广告(右)', '<script src=\\''http://cdn.img.dbplay.com/userfiles/poster/gameBannerRight.js\\'' language=\\''javascript\\''></script>', '<script src=\\''http://cdn.img.dbplay.com/userfiles/poster/gameBannerRight.js\\'' language=\\''javascript\\''></script>', 1352347292, 1353574318, 1361344472, 0, 0, 0, 0),
(6, 'indexTonLan1', '首页通栏广告1', '<script src=\\''http://cdn.img.dbplay.com/userfiles/poster/indexTonLan1.js\\'' language=\\''javascript\\''></script>', '<script src=\\''http://cdn.img.dbplay.com/userfiles/poster/indexTonLan1.js\\'' language=\\''javascript\\''></script>', 1352347292, 1353574318, 1361344494, 0, 0, 0, 0),
(7, 'indexTonLan2', '首页通栏广告2', '<script src=\\''http://cdn.img.dbplay.com/userfiles/poster/indexTonLan2.js\\'' language=\\''javascript\\''></script>', '<script src=\\''http://cdn.img.dbplay.com/userfiles/poster/indexTonLan2.js\\'' language=\\''javascript\\''></script>', 1352347292, 1353574318, 1361344528, 0, 0, 0, 0),
(8, 'indexFloatAD', '首页右侧漂浮富媒体广告', '<script src=\\''http://cdn.img.dbplay.com/userfiles/poster/indexFloatAD.js\\'' language=\\''javascript\\''></script>', '<script src=\\''http://cdn.img.dbplay.com/userfiles/poster/indexFloatAD.js\\'' language=\\''javascript\\''></script>', 1352347292, 1353574318, 1361344557, 0, 0, 0, 0),
(9, 'gameTextLink', '找游戏页面文字链', '<script src=\\''http://cdn.img.dbplay.com/userfiles/poster/gameTextLink.js\\'' language=\\''javascript\\''></script>', '<script src=\\''http://cdn.img.dbplay.com/userfiles/poster/gameTextLink.js\\'' language=\\''javascript\\''></script>', 1352347292, 1353574318, 1361344580, 0, 0, 0, 0),
(10, 'innerfooterAD1', '内容底部图片广告', '<script src=\\''http://cdn.img.dbplay.com/userfiles/poster/innerfooterAD1.js\\'' language=\\''javascript\\''></script>', '<script src=\\''http://cdn.img.dbplay.com/userfiles/poster/innerfooterAD1.js\\'' language=\\''javascript\\''></script>', 1352347292, 1353574318, 1361344600, 0, 0, 0, 0),
(11, 'indexRightLitpic1', '首页右侧大块图', '<script src=\\''http://cdn.img.dbplay.com/userfiles/poster/indexRightLitpic1.js\\'' language=\\''javascript\\''></script>', '<script src=\\''http://cdn.img.dbplay.com/userfiles/poster/indexRightLitpic1.js\\'' language=\\''javascript\\''></script>', 1352347292, 1353574318, 1361344619, 0, 0, 0, 0),
(12, 'contentRtPicAD', '内容右侧图片广告', '<script src=\\''http://cdn.img.dbplay.com/userfiles/poster/contentRtPicAD.js\\'' language=\\''javascript\\''></script>', '<script src=\\''http://cdn.img.dbplay.com/userfiles/poster/contentRtPicAD.js\\'' language=\\''javascript\\''></script>', 1352347292, 1353574318, 1361344643, 0, 0, 0, 0),
(13, 'gameTopRec', '找游戏顶部游戏推荐', '<script src=\\''http://cdn.img.dbplay.com/userfiles/poster/gameTopRec.js\\'' language=\\''javascript\\''></script>', '<script src=\\''http://cdn.img.dbplay.com/userfiles/poster/gameTopRec.js\\'' language=\\''javascript\\''></script>', 1352347292, 1353574318, 1361344671, 0, 0, 0, 0);

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
  `index_type` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

INSERT INTO `zq_types` (`id`, `name`, `title`, `description`, `table_name`, `keywords`, `ishidden`, `order`, `index_type`) VALUES
(1, 'game', '找游戏', '', 'games', '', 0, 2, 'lists'),
(2, 'kaifu', '开服表', '', 'kaifus', '', 0, 3, 'lists'),
(3, 'kaice', '开测表', '', 'kaices', '', 0, 4, 'lists'),
(4, 'gift', '礼包', '', 'gifts', '', 0, 5, 'lists'),
(5, 'article', '资讯', '', 'articles', '', 0, 1, 'index'),
(6, 'company', '厂商大全', '', 'companies', '', 0, 6, 'lists'),
(7, 'gallery', '图库', '', 'galleries', '', 0, 7, 'lists');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
