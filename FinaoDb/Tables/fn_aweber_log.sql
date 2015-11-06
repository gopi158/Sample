CREATE TABLE IF NOT EXISTS `fn_aweber_log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) DEFAULT NULL,
  `flag` varchar(100) DEFAULT '0',
  `status` varchar(100) DEFAULT '0',
  `uid` varchar(20) NOT NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=627;