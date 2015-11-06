CREATE TABLE IF NOT EXISTS `fn_like` (
  `like_id` int(11) NOT NULL AUTO_INCREMENT,
  `like_type` varchar(50) NOT NULL,
  `source_like_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_date` datetime DEFAULT NULL,
  PRIMARY KEY (`like_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;