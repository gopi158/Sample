CREATE TABLE IF NOT EXISTS `fn_profileview` (
  `profileview_id` int(11) NOT NULL AUTO_INCREMENT,
  `viewer_userid` int(11) NOT NULL,
  `viewed_userid` int(11) NOT NULL,
  `user_sessionid` varchar(20) NOT NULL,
  `createddate` datetime DEFAULT NULL,
  PRIMARY KEY (`profileview_id`),
  KEY `fk_profview_vieweruusr` (`viewer_userid`),
  KEY `fk_profview_viewedusr` (`viewed_userid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;