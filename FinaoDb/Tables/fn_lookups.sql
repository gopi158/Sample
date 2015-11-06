CREATE TABLE IF NOT EXISTS `fn_lookups` (
  `lookup_id` int(11) NOT NULL AUTO_INCREMENT,
  `lookup_name` varchar(150) NOT NULL,
  `lookup_type` varchar(150) NOT NULL,
  `lookup_status` int(11) NOT NULL,
  `lookup_parentid` int(11) DEFAULT '0',
  `createdate` datetime NOT NULL,
  `updateddate` datetime DEFAULT NULL,
  PRIMARY KEY (`lookup_id`),
  KEY `ind_lookup_year` (`lookup_name`,`lookup_type`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=77 ;