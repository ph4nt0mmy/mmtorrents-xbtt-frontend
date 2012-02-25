CREATE TABLE IF NOT EXISTS `addedrequests` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `requestid` int(10) unsigned NOT NULL default '0',
  `userid` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `pollid` (`id`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `banners` (
  `id` int(10) NOT NULL auto_increment,
  `url` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `bannings` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `ban` varchar(255) character set latin2 collate latin2_hungarian_ci NOT NULL,
  `added` datetime NOT NULL default '0000-00-00 00:00:00',
  `addedby` int(10) unsigned NOT NULL default '0',
  `comment` varchar(255) character set latin2 collate latin2_hungarian_ci NOT NULL default '',
  `ip_or_email` enum('ip','email') character set latin2 collate latin2_hungarian_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `bookmarks` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `fid` int(10) unsigned NOT NULL default '0',
  `userid` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(30) NOT NULL default '',
  `sub` int(10) NOT NULL default '0',
  `sort_index` int(10) unsigned NOT NULL default '0',
  `image` varchar(255) NOT NULL default '',
  `credit` int(10) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=244 ;

INSERT INTO `categories` (`id`, `name`, `sub`, `sort_index`, `image`, `credit`) VALUES
(1, 'MP3 (Hun)', 0, 1, 'mp3_hun.gif', 0),
(10, 'MP3 (K�lf.)', 0, 1, 'mp3.gif', 0),
(20, 'Lossless Audio', 0, 1, 'lossless2.gif', 0),
(30, 'Film/XVID (Hun)', 0, 1, 'xvid_hun.gif', 0),
(40, 'Film/XVID (K�lf.)', 0, 1, 'xvid.gif', 0),
(50, 'Film/DVD (Hun)', 0, 1, 'dvd_hun.gif', 0),
(60, 'Film/DVD (K�lf.)', 0, 1, 'dvd.gif', 0),
(70, 'Sorozat (Hun)', 0, 1, 'series_hun.gif', 0),
(90, 'Programok', 0, 1, 'progv2.gif', 0),
(95, 'J�t�kok', 0, 1, 'game_fil.gif', 0),
(100, 'Ebook', 0, 1, 'ebook.gif', 0),
(116, 'XXX', 0, 1, 'xxx.gif', 0),
(233, 'Egy�b', 0, 1, 'other_fil.gif', 0),
(231, 'Vide�klippek', 0, 1, 'klip.gif', 0),
(229, 'Mese', 0, 1, 'mese.gif', 0),
(232, 'Fun', 0, 1, 'fun.gif', 0),
(234, 'Anime', 0, 1, 'anime.gif', 0),
(101, 'Ebook (Hun)', 0, 1, 'ebook_hun.gif', 0),
(91, 'PDA', 0, 1, 'pda.gif', 0),
(92, 'Mobil', 0, 1, 'mobil.gif', 0),
(71, 'Sorozat (K�lf.)', 0, 1, 'series.gif', 0),
(235, 'Playstation 2', 0, 0, 'ps2.gif', 0),
(236, 'Retro', 0, 0, 'retro.gif', 0),
(237, 'XXX k�pek', 0, 0, 'sexy_pictures.gif', 0),
(238, 'Xbox 360', 0, 0, 'xbox360.gif', 0),
(239, 'HD (K�lf.)', 0, 0, 'hd.gif', 0),
(240, 'HD (Hun)', 0, 0, 'hd_hun.gif', 0),
(241, 'Wii', 0, 0, 'wii.gif', 0),
(242, 'XXX dvd', 0, 0, 'xxxdvd.gif', 0),
(243, 'Linux', 0, 0, 'linux.gif', 0);

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `fid` int(10) NOT NULL,
  `added` datetime NOT NULL default '0000-00-00 00:00:00',
  `text` text NOT NULL,
  `ori_text` text NOT NULL,
  `userid` int(10) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `fid` (`fid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `credits` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `points` int(10) unsigned NOT NULL default '0',
  `sql` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

INSERT INTO `credits` (`id`, `name`, `points`, `sql`) VALUES
(1, '1 GB felt�lt�s', 5000, 'uploaded=uploaded+1073741824'),
(2, '3 GB felt�lt�s', 12000, 'uploaded=uploaded+3221225472'),
(3, '5 GB felt�lt�s', 20000, 'uploaded=uploaded+5368709120'),
(4, '10 GB felt�lt�s', 30000, 'uploaded=uploaded+10737418240'),
(5, '1 db megh�v�', 5000, 'invites=invites+1'),
(6, '3 db megh�v�', 12000, 'invites=invites+3');

CREATE TABLE IF NOT EXISTS `forums` (
  `sort` tinyint(3) unsigned NOT NULL default '0',
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(60) NOT NULL default '',
  `description` varchar(200) default NULL,
  `cat` tinyint(3) unsigned NOT NULL default '1',
  `minclassread` tinyint(3) NOT NULL default '1',
  `minclasswrite` tinyint(3) NOT NULL default '1',
  `minclasscreate` tinyint(3) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;


INSERT INTO `forums` (`sort`, `id`, `name`, `description`, `cat`, `minclassread`, `minclasswrite`, `minclasscreate`) VALUES
(0, 1, 'mmtorrents f�rum', '�ltal�nos f�rum', 1, 1, 1, 1),
(0, 2, 'Seg�ts�gek', 'Let�lt�shez, felt�lt�shez, stb', 2, 0, 0, 0),
(0, 3, 'K�rd�sek', 'Az oldalr�l, torrentez�sr�l', 1, 0, 0, 0),
(0, 4, 'Offtopic', 'Ami nem f�r a t�bbi kateg�ri�ba', 1, 0, 0, 0),
(0, 5, 'Bemutatkoz�s', 'Itt �rhatsz magadr�l', 1, 1, 1, 1);

CREATE TABLE IF NOT EXISTS `friends` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `friendid` int(10) unsigned NOT NULL default '0',
  `userid` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `invited` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `invitedid` int(10) unsigned NOT NULL default '0',
  `userid` int(10) unsigned NOT NULL default '0',
  `used` enum('no','yes') default 'no',
  `random` varchar(40) NOT NULL,
  `added` datetime NOT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL auto_increment,
  `senderid` int(10) NOT NULL,
  `receiverid` int(10) NOT NULL,
  `title` varchar(255) NOT NULL,
  `msgtext` text NOT NULL,
  `added` datetime NOT NULL default '0000-00-00 00:00:00',
  `readed` enum('no','yes') character set latin2 collate latin2_hungarian_ci NOT NULL default 'no',
  `senderdeleted` enum('no','yes') character set latin2 collate latin2_hungarian_ci NOT NULL default 'no',
  `receiverdeleted` enum('no','yes') character set latin2 collate latin2_hungarian_ci NOT NULL default 'no',
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL auto_increment,
  `body` text character set latin1 NOT NULL,
  `userid` int(10) NOT NULL default '0',
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  `title` varchar(40) character set latin1 NOT NULL,
  `lang` varchar(10) character set latin1 NOT NULL default 'hun',
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=50 ;




CREATE TABLE IF NOT EXISTS `poller` (
  `ID` int(11) NOT NULL auto_increment,
  `startDate` int(10) NOT NULL default '0',
  `endDate` int(10) NOT NULL default '0',
  `pollerTitle` varchar(255) character set latin1 default NULL,
  `starterID` mediumint(8) NOT NULL default '0',
  `active` enum('yes','no') NOT NULL default 'no',
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 PACK_KEYS=0 AUTO_INCREMENT=10 ;


CREATE TABLE IF NOT EXISTS `poller_option` (
  `ID` int(11) NOT NULL auto_increment,
  `pollerID` int(11) default NULL,
  `optionText` varchar(255) character set latin1 default NULL,
  `pollerOrder` int(11) default NULL,
  `defaultChecked` char(1) default '0',
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 PACK_KEYS=0 AUTO_INCREMENT=34 ;

CREATE TABLE IF NOT EXISTS `poller_vote` (
  `ID` int(11) NOT NULL auto_increment,
  `pollerID` int(11) NOT NULL default '0',
  `optionID` int(11) default NULL,
  `ipAddress` bigint(11) default '0',
  `voteDate` int(10) NOT NULL default '0',
  `memberID` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 PACK_KEYS=0 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `topicid` int(10) unsigned NOT NULL default '0',
  `userid` int(10) unsigned NOT NULL default '0',
  `added` datetime NOT NULL default '0000-00-00 00:00:00',
  `body` text,
  `editedby` int(10) unsigned NOT NULL default '0',
  `editedat` datetime default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  KEY `topicid` (`topicid`),
  KEY `userid` (`userid`),
  FULLTEXT KEY `body` (`body`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `readposts` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `userid` int(10) unsigned NOT NULL default '0',
  `topicid` int(10) unsigned NOT NULL default '0',
  `lastpostread` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `userid` (`id`),
  KEY `topicid` (`topicid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `recover` (
  `id` int(11) NOT NULL auto_increment,
  `randomkulcs` varchar(30) character set latin2 collate latin2_hungarian_ci NOT NULL,
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  `email` varchar(255) character set latin2 collate latin2_hungarian_ci NOT NULL,
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `randomkulcs` (`randomkulcs`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `register` (
  `id` int(11) NOT NULL auto_increment,
  `randomkulcs` varchar(30) character set latin1 NOT NULL,
  `usernev` varchar(16) character set latin1 NOT NULL,
  `userpass` varchar(40) character set latin1 NOT NULL,
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  `lang` varchar(10) character set latin1 NOT NULL default 'hun',
  `email` varchar(255) character set latin1 NOT NULL,
  `sex` enum('female','male') character set latin1 NOT NULL default 'male',
  `introduce` text character set latin1,
  `machineon` text character set latin1,
  `downspeed` varchar(255) character set latin1 default NULL,
  `upspeed` varchar(255) character set latin1 default NULL,
  `invitedby` int(10) NOT NULL,
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `usernev` (`usernev`),
  UNIQUE KEY `randomkulcs` (`randomkulcs`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `requests` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `userid` int(10) unsigned NOT NULL default '0',
  `request` varchar(225) default NULL,
  `descr` text NOT NULL,
  `added` datetime NOT NULL default '0000-00-00 00:00:00',
  `fulfilled` datetime NOT NULL default '0000-00-00 00:00:00',
  `hits` int(10) unsigned NOT NULL default '0',
  `cat` int(10) unsigned NOT NULL default '0',
  `filled` varchar(255) default NULL,
  `filledby` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `staff` (
  `uid` int(11) NOT NULL auto_increment,
  `password` varchar(40) character set latin1 NOT NULL,
  `username` varchar(40) character set latin1 NOT NULL,
  `id_level` int(10) NOT NULL default '1',
  `email` varchar(30) character set latin1 NOT NULL,
  `language` varchar(10) character set latin1 NOT NULL default 'hun',
  `joined` datetime NOT NULL default '0000-00-00 00:00:00',
  `lastconnect` datetime NOT NULL default '0000-00-00 00:00:00',
  `lip` bigint(11) default '0',
  `mmuid` int(10) NOT NULL default '0',
  PRIMARY KEY  (`uid`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

CREATE TABLE IF NOT EXISTS `statpages` (
  `id` varchar(40) NOT NULL,
  `title` varchar(255) NOT NULL,
  `htmlcode` text NOT NULL,
  `lastmodded` datetime NOT NULL default '0000-00-00 00:00:00',
  `lang` varchar(5) default NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `summary` (
  `info_hash` char(40) NOT NULL default '',
  `dlbytes` bigint(20) unsigned NOT NULL default '0',
  `seeds` int(10) unsigned NOT NULL default '0',
  `leechers` int(10) unsigned NOT NULL default '0',
  `finished` int(10) unsigned NOT NULL default '0',
  `lastcycle` int(10) unsigned NOT NULL default '0',
  `lastSpeedCycle` int(10) unsigned NOT NULL default '0',
  `speed` bigint(20) unsigned NOT NULL default '0',
  PRIMARY KEY  (`info_hash`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `systemlog` (
  `id` int(11) NOT NULL auto_increment,
  `event` text NOT NULL,
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  `ip` varchar(40) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `tasks` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `lastupdate` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

INSERT INTO `tasks` (`id`, `name`, `lastupdate`) VALUES
(1, 'warnings', '2009-03-24 15:11:22'),
(2, 'banleech', '2008-05-26 09:32:23'),
(3, 'unbanleech', '2008-05-26 09:32:23');

CREATE TABLE IF NOT EXISTS `thanks` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `fid` int(10) NOT NULL,
  `userid` int(10) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `fid` (`fid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `topics` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `userid` int(10) unsigned NOT NULL default '0',
  `subject` varchar(40) default NULL,
  `locked` enum('yes','no') NOT NULL default 'no',
  `forumid` int(10) unsigned NOT NULL default '0',
  `lastpost` int(10) unsigned NOT NULL default '0',
  `sticky` enum('yes','no') NOT NULL default 'no',
  `views` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `userid` (`userid`),
  KEY `subject` (`subject`),
  KEY `lastpost` (`lastpost`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=181 ;


CREATE TABLE IF NOT EXISTS `torrents` (
  `fid` int(11) NOT NULL auto_increment,
  `info_hash` blob NOT NULL,
  `leechers` int(11) NOT NULL default '0',
  `seeders` int(11) NOT NULL default '0',
  `completed` int(11) NOT NULL default '0',
  `flags` int(11) NOT NULL default '0',
  `mtime` int(11) NOT NULL default '0',
  `ctime` int(11) NOT NULL default '0',
  `announced_http` int(11) NOT NULL,
  `announced_http_compact` int(11) NOT NULL,
  `announced_http_no_peer_id` int(11) NOT NULL,
  `announced_udp` int(11) NOT NULL,
  `scraped_http` int(11) NOT NULL,
  `scraped_udp` int(11) NOT NULL,
  `started` int(11) NOT NULL,
  `stopped` int(11) NOT NULL,
  `times_completed` int(10) unsigned NOT NULL default '0',
  `balance` int(11) NOT NULL default '0',
  `hash` varchar(40) NOT NULL default '',
  `filename` varchar(250) NOT NULL default '',
  `url` varchar(250) NOT NULL default '',
  `added` datetime NOT NULL default '0000-00-00 00:00:00',
  `size` bigint(20) NOT NULL default '0',
  `description` text,
  `category` int(10) unsigned NOT NULL default '1',
  `announce_url` varchar(100) NOT NULL default '',
  `uploader` int(10) NOT NULL default '1',
  `anonymous` enum('true','false') NOT NULL default 'false',
  `nfo` text NOT NULL,
  `staff_comment` varchar(255) NOT NULL,
  `staff_ok` int(2) NOT NULL default '0',
  `requested` enum('true','false') NOT NULL default 'false',
  `image` varchar(255) default NULL,
  `seedreq` datetime NOT NULL default '0000-00-00 00:00:00',
  `lastupdate` datetime NOT NULL default '0000-00-00 00:00:00',
  `seedtime` varchar(255) default NULL,
  `seedspeed` varchar(255) default NULL,
  `gold` int(11) NOT NULL default '0',
  `mark_deleted` enum('no','yes') default 'no',
  PRIMARY KEY  (`fid`),
  UNIQUE KEY `info_hash` (`info_hash`(20)),
  KEY `flags` (`flags`),
  KEY `category` (`category`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `users` (
  `uid` int(11) NOT NULL auto_increment,
  `name` varchar(8) NOT NULL,
  `username` varchar(40) default NULL,
  `password` varchar(40) NOT NULL,
  `style` VARCHAR( 40 ) DEFAULT  'base';
  `id_level` int(10) NOT NULL default '1',
  `random` int(10) default '0',
  `email` varchar(30) NOT NULL,
  `language` varchar(10) NOT NULL default 'hun',
  `joined` datetime NOT NULL default '0000-00-00 00:00:00',
  `lastconnect` datetime NOT NULL default '0000-00-00 00:00:00',
  `lip` bigint(11) default '0',
  `downloaded` bigint(20) NOT NULL default '0',
  `uploaded` bigint(20) NOT NULL default '0',
  `credit` int(10) NOT NULL default '0',
  `avatar` varchar(100) default NULL,
  `flag` tinyint(1) unsigned NOT NULL default '0',
  `cip` varchar(15) default NULL,
  `invites` int(10) NOT NULL default '0',
  `invited_by` int(10) NOT NULL default '0',
  `invitedate` datetime NOT NULL default '0000-00-00 00:00:00',
  `feltolthet` enum('yes','no') NOT NULL default 'yes',
  `pass` blob NOT NULL,
  `can_leech` tinyint(4) NOT NULL default '1',
  `wait_time` int(11) NOT NULL default '0',
  `peers_limit` int(11) NOT NULL default '0',
  `torrents_limit` int(11) NOT NULL default '0',
  `torrent_pass` varchar(32) NOT NULL,
  `torrent_pass_secret` bigint(20) NOT NULL default '0',
  `fid_end` int(11) NOT NULL,
  `sex` enum('female','male') NOT NULL default 'male',
  `introduce` text,
  `machineon` text,
  `downspeed` varchar(255) default NULL,
  `upspeed` varchar(255) default NULL,
  `signature` varchar(255) default NULL,
  `bornyear` int(10) default NULL,
  `pid` varchar(32) default NULL,
  `lastip` varchar(20) default NULL,
  `lastdonate` datetime NOT NULL default '0000-00-00 00:00:00',
  `donatedx` int(4) NOT NULL default '0',
  `disabled` enum('yes','no') NOT NULL default 'no',
  PRIMARY KEY  (`uid`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `users_level` (
  `id` int(10) NOT NULL auto_increment,
  `id_level` int(11) NOT NULL default '0',
  `level` varchar(50) NOT NULL default '',
  `view_torrents` enum('yes','no') NOT NULL default 'yes',
  `edit_torrents` enum('yes','no') NOT NULL default 'no',
  `delete_torrents` enum('yes','no') NOT NULL default 'no',
  `view_users` enum('yes','no') NOT NULL default 'yes',
  `edit_users` enum('yes','no') NOT NULL default 'no',
  `delete_users` enum('yes','no') NOT NULL default 'no',
  `view_news` enum('yes','no') NOT NULL default 'yes',
  `edit_news` enum('yes','no') NOT NULL default 'no',
  `delete_news` enum('yes','no') NOT NULL default 'no',
  `can_upload` enum('yes','no') NOT NULL default 'no',
  `can_download` enum('yes','no') NOT NULL default 'yes',
  `view_forum` enum('yes','no') NOT NULL default 'yes',
  `edit_forum` enum('yes','no') NOT NULL default 'yes',
  `delete_forum` enum('yes','no') NOT NULL default 'no',
  `predef_level` enum('guest','validating','member','uploader','vip','moderator','admin','owner') NOT NULL default 'guest',
  `can_be_deleted` enum('yes','no') NOT NULL default 'yes',
  `admin_access` enum('yes','no') NOT NULL default 'no',
  `prefixcolor` varchar(40) NOT NULL default '',
  `suffixcolor` varchar(40) NOT NULL default '',
  `WT` int(11) NOT NULL default '0',
  `szalak` int(10) default NULL,
  UNIQUE KEY `base` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

INSERT INTO `users_level` (`id`, `id_level`, `level`, `view_torrents`, `edit_torrents`, `delete_torrents`, `view_users`, `edit_users`, `delete_users`, `view_news`, `edit_news`, `delete_news`, `can_upload`, `can_download`, `view_forum`, `edit_forum`, `delete_forum`, `predef_level`, `can_be_deleted`, `admin_access`, `prefixcolor`, `suffixcolor`, `WT`, `szalak`) VALUES
(1, 1, 'Felhaszn�l�', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'member', 'no', 'no', '', '', 0, NULL),
(2, 2, 'Segit�', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'member', 'no', 'no', '<span style=\\''color:blue\\''>', '</span>', 0, NULL),
(3, 3, 'Felt�lt�', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'member', 'no', 'no', '<span style=\\''color:navy\\''>', '</span>', 0, 4),
(4, 4, 'Moder�tor', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'member', 'no', 'no', '<span style=\\''color:red\\''>', '</span>', 0, 1),
(5, 5, 'Sysop', 'yes', 'no', 'no', 'yes', 'no', 'no', 'yes', 'no', 'no', 'no', 'yes', 'yes', 'yes', 'no', 'member', 'yes', 'no', '<span style=\\''color:red\\''>', '</span>', 0, NULL),
(6, 6, 'Tulajdonos', 'yes', 'no', 'no', 'yes', 'no', 'no', 'yes', 'no', 'no', 'no', 'yes', 'yes', 'yes', 'no', 'guest', 'yes', 'no', '<span style=\\''color:red\\''>', '</span>', 0, NULL),
(7, 7, 'Rendszer', 'yes', 'no', 'no', 'yes', 'no', 'no', 'yes', 'no', 'no', 'no', 'yes', 'yes', 'yes', 'no', 'admin', 'yes', 'no', '<span style=\\''color:red\\''>', '</span>', 0, NULL),
(8, 8, 'Szuper felt�lt�', 'yes', 'no', 'no', 'yes', 'no', 'no', 'yes', 'no', 'no', 'no', 'yes', 'yes', 'yes', 'no', 'uploader', 'yes', 'no', '<span style=\\''color:navy\\''>', '</span>', 0, NULL),
(9, 9, 'VIP', 'yes', 'no', 'no', 'yes', 'no', 'no', 'yes', 'no', 'no', 'no', 'yes', 'yes', 'yes', 'no', 'vip', 'yes', 'no', '<span style=\\''color:orange\\''>', '</span>', 0, NULL);

CREATE TABLE IF NOT EXISTS `warnings` (
  `id` int(10) NOT NULL auto_increment,
  `userid` int(10) NOT NULL default '0',
  `warnedby` int(10) NOT NULL default '0',
  `added` datetime NOT NULL default '0000-00-00 00:00:00',
  `warnedfor` int(11) NOT NULL default '0',
  `reason` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=466 ;

CREATE TABLE IF NOT EXISTS `xbt_announce_log` (
  `id` int(11) NOT NULL auto_increment,
  `ipa` int(10) unsigned NOT NULL,
  `port` int(11) NOT NULL,
  `event` int(11) NOT NULL,
  `info_hash` blob NOT NULL,
  `peer_id` blob NOT NULL,
  `useragent` varchar(20) NOT NULL,
  `downloaded` bigint(20) NOT NULL,
  `left0` bigint(20) NOT NULL,
  `uploaded` bigint(20) NOT NULL,
  `uid` int(11) NOT NULL,
  `mtime` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `xbt_cheat` (
  `id` int(11) NOT NULL auto_increment,
  `uid` int(11) NOT NULL,
  `ipa` int(10) unsigned NOT NULL,
  `peer_id` blob NOT NULL,
  `upspeed` bigint(20) NOT NULL,
  `tstamp` int(11) NOT NULL,
  `uploaded` bigint(20) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `xbt_config` (
  `name` varchar(255) NOT NULL default '',
  `value` varchar(255) NOT NULL default ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `xbt_config` (`name`, `value`) VALUES
('announce_interval', '1800'),
('anonymous_connect', '0'),
('anonymous_announce', '0'),
('anonymous_scrape', '0'),
('auto_register', '0'),
('clean_up_interval', '60'),
('daemon', '1'),
('debug', '0'),
('gzip_announce', '1'),
('gzip_debug', '1'),
('gzip_scrape', '1'),
('listen_check', '0'),
('listen_ipa', '*'),
('listen_port', '9998'),
('log_access', '0'),
('log_announce', '0'),
('log_scrape', '0'),
('pid_file', ''),
('read_config_interval', '180'),
('read_db_interval', '10'),
('redirect_url', ''),
('scrape_interval', '1800'),
('table_announce_log', 'xbt_announce_log'),
('table_files', 'torrents'),
('table_scrape_log', 'xbt_scrape_log'),
('table_users', 'users'),
('write_db_interval', '10'),
('query_log', 'query_log.txt'),
('torrent_pass_private_key', 'wVKdvfjBvYgM4NeYpYmP0k8b5T7');

CREATE TABLE IF NOT EXISTS `xbt_deny_from_hosts` (
  `begin` int(11) NOT NULL default '0',
  `end` int(11) NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `xbt_files_users` (
  `fid` int(11) NOT NULL default '0',
  `uid` int(11) NOT NULL default '0',
  `active` tinyint(4) NOT NULL default '0',
  `announced` int(11) NOT NULL default '0',
  `completed` int(11) NOT NULL default '0',
  `downloaded` bigint(20) NOT NULL default '0',
  `left` bigint(20) NOT NULL default '0',
  `uploaded` bigint(20) NOT NULL default '0',
  `mtime` int(11) NOT NULL default '0',
  `upspeed` bigint(20) NOT NULL,
  `downspeed` bigint(20) NOT NULL,
  `timespent` bigint(20) NOT NULL,
  `useragent` varchar(40) NOT NULL,
  `connectable` tinyint(4) NOT NULL default '1',
  `peer_id` varchar(8) NOT NULL,
  `ipa` int(11) NOT NULL,
  UNIQUE KEY `fid` (`fid`,`uid`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `xbt_ipas` (
  `ipa` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `mtime` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`ipa`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `xbt_scrape_log` (
  `id` int(11) NOT NULL auto_increment,
  `ipa` int(11) NOT NULL default '0',
  `info_hash` blob,
  `uid` int(11) NOT NULL default '0',
  `mtime` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `xbt_snatched` (
  `uid` int(11) NOT NULL default '0',
  `tstamp` int(11) NOT NULL,
  `fid` int(11) NOT NULL,
  `last_action` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `uploaded` bigint(20) NOT NULL,
  `downloaded` bigint(20) NOT NULL,
  `connectable` tinyint(4) NOT NULL,
  `seeding` enum('yes','no') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `countries` (
`id` INT( 10 ) NOT NULL AUTO_INCREMENT ,
`country` VARCHAR( 40 ) NOT NULL ,
`isocode` VARCHAR( 40 ) NOT NULL ,
PRIMARY KEY (  `id` )
);

