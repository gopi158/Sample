CREATE TABLE IF NOT EXISTS `fn_tracking` (
  `tracking_id` int(11) NOT NULL AUTO_INCREMENT,
  `tracker_userid` int(11) NOT NULL,
  `tracked_userid` int(11) NOT NULL,
  `tracked_tileid` int(11) NOT NULL,
  `view_status` int(10) NOT NULL DEFAULT '0',
  `createddate` datetime NOT NULL,
  `status` int(11) NOT NULL,
  `tracked_type` int(11) DEFAULT NULL,
  PRIMARY KEY (`tracking_id`),
  KEY `fk_track_trackerusrid` (`tracker_userid`),
  KEY `fk_track_trackedusrid` (`tracked_userid`),
  KEY `fk_track_tileid` (`tracked_tileid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2117 ;