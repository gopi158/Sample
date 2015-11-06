DROP TABLE IF EXISTS `splash_details`;
CREATE TABLE `splash_details` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(224) NOT NULL,
  `phone_num` varchar(224) NOT NULL,
  `ip` varchar(224) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=405 DEFAULT CHARSET=latin1;
