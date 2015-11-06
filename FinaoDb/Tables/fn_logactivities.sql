CREATE TABLE IF NOT EXISTS `fn_logactivities` (
  `logactivity_id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `user_sessionid` int(11) NOT NULL,
  `logindatetime` datetime NOT NULL,
  `logoutdatetime` datetime NOT NULL,
  PRIMARY KEY (`logactivity_id`),
  KEY `fk_log_userid` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;