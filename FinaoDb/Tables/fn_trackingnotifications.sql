CREATE TABLE IF NOT EXISTS `fn_trackingnotifications` (
  `trackingnotification_id` int(11) NOT NULL AUTO_INCREMENT,
  `tracker_userid` int(11) NOT NULL,
  `tile_id` int(11) NOT NULL,
  `finao_id` int(11) DEFAULT NULL,
  `journal_id` int(11) DEFAULT NULL,
  `notification_action` int(11) NOT NULL,
  `updateby` int(11) NOT NULL,
  `updateddate` datetime NOT NULL,
  `createdby` int(11) NOT NULL,
  `createddate` datetime NOT NULL,
  PRIMARY KEY (`trackingnotification_id`),
  KEY `fk_tracknoti_trackerid` (`tracker_userid`),
  KEY `fk_tracknoti_tileid` (`tile_id`),
  KEY `fk_tracknoti_updatedby` (`updateby`),
  KEY `fk_tracknoti_createdby` (`createdby`),
  KEY `fk_tracknoti_notifyaction` (`notification_action`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2249 ;
