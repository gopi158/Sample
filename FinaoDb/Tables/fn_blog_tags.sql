CREATE TABLE IF NOT EXISTS `fn_blog_tags` (
  `tag_id` int(11) NOT NULL AUTO_INCREMENT,
  `tag_name` varchar(150) NOT NULL,
  `tag_status` int(11) NOT NULL,
  `createdate` datetime NOT NULL,
  `createdby` int(11) NOT NULL,
  PRIMARY KEY (`tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;