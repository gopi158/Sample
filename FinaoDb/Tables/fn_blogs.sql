CREATE TABLE IF NOT EXISTS `fn_blogs` (
  `blog_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `blog_title` varchar(255) NOT NULL,
  `blog_category_id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `blog_content` varchar(4000) NOT NULL,
  `blog_parent_id` int(11) DEFAULT NULL,
  `blog_post_under` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `createdby` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `updatedby` int(11) NOT NULL,
  `updated_date` datetime NOT NULL,
  PRIMARY KEY (`blog_id`),
  KEY `fk_blog_category` (`blog_category_id`),
  KEY `fk_blog_userid` (`createdby`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
