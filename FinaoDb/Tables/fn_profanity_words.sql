CREATE TABLE IF NOT EXISTS `fn_profanity_words` (
  `badwords_id` int(11) NOT NULL AUTO_INCREMENT,
  `badword` varchar(100) NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1',
  PRIMARY KEY (`badwords_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=467 ;