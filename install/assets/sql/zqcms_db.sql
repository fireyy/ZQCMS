DROP TABLE IF EXISTS `#@__admin`;
CREATE TABLE IF NOT EXISTS `#@__admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `passwd` varchar(255) NOT NULL,
  `logintime` int(10) NOT NULL,
  `loginip` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `#@__articles`;
CREATE TABLE IF NOT EXISTS `#@__articles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `guid` varchar(64) NOT NULL,
  `typeid` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `shorttitle` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `flag` set('c','f','p','f','s','j','a','b') NOT NULL,
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
  `body` mediumint(9) NOT NULL,
  `redirecturl` varchar(255) NOT NULL,
  `thumb` varchar(255) NOT NULL,
  `external_links` varchar(255) NOT NULL,
  `game_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `#@__companies`;
CREATE TABLE IF NOT EXISTS `#@__companies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `guid` varchar(64) NOT NULL,
  `typeid` int(11) NOT NULL,
  `short_name` varchar(64) NOT NULL,
  `full_name` varchar(128) NOT NULL,
  `description` varchar(255) NOT NULL,
  `flag` set('c','f','p','f','s','j','a','b') NOT NULL,
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
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `#@__games`;
CREATE TABLE IF NOT EXISTS `#@__games` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `guid` varchar(64) NOT NULL,
  `typeid` int(11) NOT NULL,
  `game_name` varchar(255) NOT NULL,
  `shorttitle` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `flag` set('c','f','p','f','s','j','a','b') NOT NULL,
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
  `oper_id` text NOT NULL,
  `pub_id` int(11) NOT NULL,
  `pinyin` char(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `#@__gifts`;
CREATE TABLE IF NOT EXISTS `#@__gifts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `guid` varchar(64) NOT NULL,
  `typeid` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `shorttitle` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `flag` set('c','f','p','f','s','j','a','b') NOT NULL,
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `#@__kaices`;
CREATE TABLE IF NOT EXISTS `#@__kaices` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `guid` varchar(64) NOT NULL,
  `typeid` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `shorttitle` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `flag` set('c','f','p','f','s','j','a','b') NOT NULL,
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `#@__kaifus`;
CREATE TABLE IF NOT EXISTS `#@__kaifus` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `guid` varchar(64) NOT NULL,
  `typeid` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `shorttitle` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `flag` set('c','f','p','f','s','j','a','b') NOT NULL,
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `#@__members`;
CREATE TABLE IF NOT EXISTS `#@__members` (
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

DROP TABLE IF EXISTS `#@__options`;
CREATE TABLE IF NOT EXISTS `#@__options` (
  `id` smallint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `value` text NOT NULL,
  `description` varchar(100) NOT NULL,
  `type` tinyint(1) NOT NULL,
  `group` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `#@__screenshots`;
CREATE TABLE IF NOT EXISTS `#@__screenshots` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `guid` varchar(64) NOT NULL,
  `typeid` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `shorttitle` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `flag` set('c','f','p','f','s','j','a','b') NOT NULL,
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
  `body` mediumint(9) NOT NULL,
  `redirecturl` varchar(255) NOT NULL,
  `thumb` varchar(255) NOT NULL,
  `external_links` varchar(255) NOT NULL,
  `game_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `#@__tags`;
CREATE TABLE IF NOT EXISTS `#@__tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `type` set('category','tag') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


DROP TABLE IF EXISTS `#@__tag_relationships`;
CREATE TABLE IF NOT EXISTS `#@__tag_relationships` (
  `aid` int(10) unsigned NOT NULL DEFAULT '0',
  `tag_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`aid`,`tag_id`),
  KEY `tag_id` (`tag_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `#@__types`;
CREATE TABLE IF NOT EXISTS `#@__types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `typedir` varchar(255) NOT NULL,
  `defaultname` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `ishidden` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;