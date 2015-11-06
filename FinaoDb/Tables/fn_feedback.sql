CREATE TABLE IF NOT EXISTS `fn_feedback` (
  `feedback_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(25) NOT NULL,
  `feedback_mesg` varchar(250) NOT NULL,
  `user_email` varchar(25) NOT NULL,
  `created_date` datetime NOT NULL,
  PRIMARY KEY (`feedback_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;