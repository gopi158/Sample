CREATE TABLE IF NOT EXISTS `fn_contactus` (
  `contact_id` int(11) NOT NULL AUTO_INCREMENT,
  `contact_name` varchar(50) DEFAULT NULL,
  `contact_company` varchar(50) DEFAULT NULL,
  `contact_help` varchar(4000) NOT NULL,
  `contact_email` varchar(50) DEFAULT NULL,
  `contact_phone` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`contact_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;