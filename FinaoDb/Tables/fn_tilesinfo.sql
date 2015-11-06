CREATE TABLE IF NOT EXISTS `fn_tilesinfo` (
  `tilesinfo_id` int(11) NOT NULL AUTO_INCREMENT,
  `tile_id` int(11) NOT NULL,
  `tilename` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `tile_imageurl` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `temp_tile_imageurl` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Is_customtile` tinyint(1) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '0',
  `createdby` int(11) NOT NULL,
  `createddate` datetime NOT NULL,
  `updatedby` int(11) NOT NULL,
  `updateddate` datetime NOT NULL,
  PRIMARY KEY (`tilesinfo_id`),
  KEY `fk_tileinfo_createdby` (`createdby`),
  KEY `fk_tileinfo_updatedby` (`updatedby`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2023 ;