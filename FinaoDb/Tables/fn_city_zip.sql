CREATE TABLE IF NOT EXISTS `fn_city_zip` (
  `city_zip_id` int(11) NOT NULL AUTO_INCREMENT,
  `city` varchar(100) NOT NULL,
  `zipcode` varchar(5) NOT NULL,
  `state` varchar(3) NOT NULL,
  `school_district` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`city_zip_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;