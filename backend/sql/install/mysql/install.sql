
CREATE TABLE IF NOT EXISTS `#__mdtickets_items` (
  `mdtickets_item_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `prio` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL DEFAULT '',
  `short` varchar(255) NOT NULL DEFAULT '',
  `detail` mediumtext NOT NULL,
  `requester` varchar(255) NOT NULL DEFAULT '',
  `deadline` date,
  `assigned` varchar(255) DEFAULT '',
  `start_date` date,
  `itoncall` varchar(55) DEFAULT NULL,
  `started` tinyint(3) NOT NULL DEFAULT 0,
  `published` tinyint(3) NOT NULL DEFAULT 1,
  `status` varchar(255) DEFAULT '',
  `token` char(32) DEFAULT NULL,
  `created_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` bigint(20) NOT NULL DEFAULT '0',
  `modified_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` bigint(20) NOT NULL DEFAULT '0',
  `locked_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `locked_by` bigint(20) NOT NULL DEFAULT '0',
  `completion_date` date DEFAULT NULL,
  `completed_by` varchar(255),
  `remark` mediumtext NOT NULL,
  `actie` varchar(255) DEFAULT '',
  PRIMARY KEY (`mdtickets_item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `#__mdtickets_lastlogins` (
  `mdtickets_lastlogin_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) DEFAULT NULL,
  `lastlogin` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `previouslogin` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `published` tinyint(3) NOT NULL DEFAULT 1,
  `token` char(32) DEFAULT NULL,
  `created_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` bigint(20) NOT NULL DEFAULT '0',
  `modified_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` bigint(20) NOT NULL DEFAULT '0',
  `locked_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `locked_by` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`mdtickets_lastlogin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;