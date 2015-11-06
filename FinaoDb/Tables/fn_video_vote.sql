CREATE TABLE IF NOT EXISTS `fn_video_vote` (
  `vote_id` int(11) NOT NULL AUTO_INCREMENT,
  `voter_userid` int(11) NOT NULL,
  `voted_userid` int(11) NOT NULL,
  `voted_sourceid` int(11) NOT NULL,
  `createddate` datetime NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`vote_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;
