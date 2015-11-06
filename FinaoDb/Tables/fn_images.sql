CREATE TABLE IF NOT EXISTS `fn_images` (
  `image_id` int(11) NOT NULL AUTO_INCREMENT,
  `upload_id` int(255) DEFAULT NULL,
  `uploadfile_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `uploadfile_path` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `caption` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `uploadedby` int(100) DEFAULT NULL,
  `uploadeddate` datetime DEFAULT NULL,
  `updatedby` int(100) DEFAULT NULL,
  `updateddate` datetime DEFAULT NULL,
  `status` int(10) DEFAULT NULL,
  `trending` int(10) DEFAULT NULL,
  PRIMARY KEY (`image_id`),
  KEY `upload_id` (`upload_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=91 ;