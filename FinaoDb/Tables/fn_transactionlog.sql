CREATE TABLE IF NOT EXISTS `fn_transactionlog` (
  `transactionlog_id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_descr` varchar(200) NOT NULL,
  `transaction_status` varchar(45) DEFAULT NULL,
  `transactiondate` datetime NOT NULL,
  `uploadfile_id` int(11) NOT NULL,
  PRIMARY KEY (`transactionlog_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;