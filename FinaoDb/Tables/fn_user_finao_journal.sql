CREATE TABLE IF NOT EXISTS `fn_user_finao_journal` (
  `finao_journal_id` int(11) NOT NULL AUTO_INCREMENT,
  `finao_id` int(11) NOT NULL,
  `finao_journal` text NOT NULL,
  `journal_status` int(11) NOT NULL,
  `journal_startdate` datetime NOT NULL,
  `journal_enddate` datetime DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `status_value` int(11) DEFAULT NULL,
  `createdby` int(11) NOT NULL,
  `createddate` datetime NOT NULL,
  `updatedby` int(11) NOT NULL,
  `updateddate` datetime NOT NULL,
  `explore_finao` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`finao_journal_id`),
  KEY `fk_usrfinaojou_finaoid` (`finao_id`),
  KEY `fk_usrfinaojou_creby` (`createdby`),
  KEY `fk_usrfinaojou_updby` (`updatedby`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=563 ;