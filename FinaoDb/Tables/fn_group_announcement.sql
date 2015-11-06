CREATE TABLE IF NOT EXISTS `fn_group_announcement` (
  `anno_id` int(11) NOT NULL AUTO_INCREMENT,
  `uploadsourcetype` int(255) DEFAULT NULL,
  `uploadsourceid` int(255) DEFAULT NULL,
  `announcement` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `createdby` int(100) DEFAULT NULL,
  `createddate` datetime DEFAULT NULL,
  `status` int(10) DEFAULT NULL,
  PRIMARY KEY (`anno_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=16 ;