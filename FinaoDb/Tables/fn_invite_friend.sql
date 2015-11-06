CREATE TABLE IF NOT EXISTS `fn_invite_friend` (
  `invite_friend_id` int(11) NOT NULL AUTO_INCREMENT,
  `source` varchar(50) DEFAULT NULL,
  `invitee_social_network_id` varchar(50) DEFAULT NULL,
  `invited_by_social_network_id` varchar(50) DEFAULT NULL,
  `invited_by_user_id` int(11) NOT NULL,
  `invited_request_id` varchar(50) DEFAULT NULL,
  `invited_date` datetime NOT NULL,
  `status` int(11) NOT NULL,
  `invitee_email` varchar(255) DEFAULT NULL,
  `invitee_user_type` int(11) NOT NULL,
  PRIMARY KEY (`invite_friend_id`),
  KEY `fk_inviteby_user` (`invited_by_user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=515 ;