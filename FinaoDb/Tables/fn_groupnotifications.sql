CREATE TABLE IF NOT EXISTS `fn_groupnotifications` (
  `trackingnotification_id` int(11) NOT NULL AUTO_INCREMENT,
  `tracker_userid` int(11) NOT NULL,
  `group_id` int(22) NOT NULL,
  `finao_id` int(11) DEFAULT NULL,
  `journal_id` int(11) DEFAULT NULL,
  `notification_action` int(11) NOT NULL,
  `updateby` int(11) NOT NULL,
  `updateddate` datetime NOT NULL,
  `createdby` int(11) NOT NULL,
  `createddate` datetime NOT NULL,
  PRIMARY KEY (`trackingnotification_id`),
  KEY `fk_tracknoti_trackerid` (`tracker_userid`),
  KEY `fk_tracknoti_tileid` (`group_id`),
  KEY `fk_tracknoti_updatedby` (`updateby`),
  KEY `fk_tracknoti_createdby` (`createdby`),
  KEY `fk_tracknoti_notifyaction` (`notification_action`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=38 ;