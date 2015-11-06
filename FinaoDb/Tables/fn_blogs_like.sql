
CREATE TABLE IF NOT EXISTS `fn_blogs_like` (
  `blog_like_id` int(11) NOT NULL AUTO_INCREMENT,
  `blog_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `like` int(5) NOT NULL,
  `rate` int(5) NOT NULL,
  PRIMARY KEY (`blog_like_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;