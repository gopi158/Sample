CREATE TABLE IF NOT EXISTS `fn_user_group` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `group_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `profile_image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `temp_profile_image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `profile_bg_image` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `temp_profile_bg_image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `group_status_ispublic` int(10) DEFAULT '0' COMMENT '0-Private1-Public',
  `group_activestatus` int(10) DEFAULT '0',
  `upload_status` int(10) DEFAULT NULL,
  `updatedby` int(10) DEFAULT NULL,
  `createddate` datetime NOT NULL,
  `updatedate` datetime DEFAULT NULL,
  PRIMARY KEY (`group_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=97 ;