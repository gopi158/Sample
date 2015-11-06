CREATE TABLE IF NOT EXISTS `fn_group_tracking` (
  `tracking_id` int(11) NOT NULL AUTO_INCREMENT,
  `tracker_userid` int(50) DEFAULT NULL,
  `tracked_userid` int(50) DEFAULT NULL,
  `tracked_groupid` int(50) DEFAULT NULL,
  `visible` int(11) NOT NULL DEFAULT '0' COMMENT '0-visible 1-not visible',
  `createddate` date DEFAULT NULL,
  `status` int(5) DEFAULT NULL,
  `view_status` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`tracking_id`),
  KEY `fk_TrackGroup` (`tracked_groupid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=14 ;