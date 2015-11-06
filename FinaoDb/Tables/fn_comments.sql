CREATE TABLE IF NOT EXISTS `fn_comments` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `goal_id` int(11) NOT NULL,
  `goal_type` varchar(50) NOT NULL,
  `comment_content` varchar(500) NOT NULL,
  `comment_author_id` int(11) NOT NULL,
  `comment_parent_id` int(11) NOT NULL,
  `comment_like` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `commented_date` datetime DEFAULT NULL,
  PRIMARY KEY (`comment_id`),
  KEY `comment_author_id` (`comment_author_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;