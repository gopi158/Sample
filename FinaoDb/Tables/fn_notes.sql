CREATE TABLE IF NOT EXISTS `fn_notes` (
  `note_id` int(11) NOT NULL AUTO_INCREMENT,
  `tracker_userid` int(55) NOT NULL,
  `tracked_userid` int(55) NOT NULL,
  `upload_sourceid` int(55) NOT NULL,
  `upload_sourcetype` int(11) NOT NULL,
  `view_status` int(10) NOT NULL DEFAULT '0',
  `block_status` int(10) NOT NULL DEFAULT '0',
  `contentnote_id` int(10) NOT NULL,
  `createddate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`note_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=57 ;