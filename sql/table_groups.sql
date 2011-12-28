CREATE TABLE IF NOT EXISTS `users_level` (
  `id` int(10) NOT NULL auto_increment,
  `group` int(10) NOT NULL default '0',
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
  `view_forum` enum('yes','no') NOT NULL default 'yes',
  `edit_forum` enum('yes','no') NOT NULL default 'yes',
  `delete_forum` enum('yes','no') NOT NULL default 'no',
  `can_be_deleted` enum('yes','no') NOT NULL default 'yes',
  `admin_access` enum('yes','no') NOT NULL default 'no',
  `prefixcolor` varchar(40) NOT NULL default '',
  `suffixcolor` varchar(40) NOT NULL default '',
  `download_slots` int(10) NOT NULL default '0',
  `upload_slots` int(10) NOT NULL default '0',
  `can_download` enum('yes','no') NOT NULL default 'no',
  UNIQUE KEY `base` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

; 0 PENDING : can not do anything, registration should be confirmed via email within 7 days after registration
; 1 REDUCED : can not upload, after 6 weeks and below 0.6 ratio everbody is reduced, download slots: 1, after 2 week as reduced user should be banned
; 2 NEWBIE : can not upload, after registration everbody is newbie for 6 weeks, download slots: 5
; 3 USER : if registered more than 6 weeks and ratio <= 1.0, download slots: 10, upload slots: 5 
; 4 POWERUSER : if registered more than 6 weeks and ratio is > 1.0, download slots: unlimited, upload slots: 10
; 5 HELPDESK
; 6 TINY_UPLOADER : upload slots: 20
; 7 UPLOADER : upload slots: unlimited
; 8 MODERATOR : upload slots: unlimited
; 9 SYSOP : upload slots: unlimited
; 10 OWNER : upload slots: unlimited

INSERT INTO `mmtorrents-dev`.`users_level` (
`id` ,
`group` ,
`level` ,
`view_torrents` ,
`edit_torrents` ,
`delete_torrents` ,
`view_users` ,
`edit_users` ,
`delete_users` ,
`view_news` ,
`edit_news` ,
`delete_news` ,
`view_forum` ,
`edit_forum` ,
`delete_forum` ,
`can_be_deleted` ,
`admin_access` ,
`prefixcolor` ,
`suffixcolor` ,
`download_slots` ,
`upload_slots` ,
`can_download`
)
VALUES (
NULL , '0', 'LEVEL_PENDING', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'yes', 'no', '', '', '0', '0', 'no'
);
