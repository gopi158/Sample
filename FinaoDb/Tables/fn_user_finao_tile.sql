CREATE TABLE IF NOT EXISTS `fn_user_finao_tile` (
  `user_tileid` int(11) NOT NULL AUTO_INCREMENT,
  `tile_id` int(11) NOT NULL,
  `tile_name` varchar(100) NOT NULL,
  `userid` int(11) NOT NULL,
  `finao_id` int(11) NOT NULL,
  `tile_profileImagurl` varchar(250) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `createddate` datetime NOT NULL,
  `createdby` int(11) NOT NULL,
  `updateddate` datetime NOT NULL,
  `updatedby` int(11) NOT NULL,
  `explore_finao` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`user_tileid`),
  KEY `fk_usrtile_userid` (`userid`),
  KEY `fk_usrtile_createdby` (`createdby`),
  KEY `fk_usrtile_updateby` (`updatedby`),
  KEY `fk_usrtile_finao` (`finao_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3126 ;