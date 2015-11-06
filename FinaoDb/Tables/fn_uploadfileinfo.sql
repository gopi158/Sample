CREATE TABLE IF NOT EXISTS `fn_uploadfileinfo` (
  `uploadfile_id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(150) NOT NULL,
  `filecommments` varchar(100) DEFAULT NULL,
  `uploadedby` int(11) NOT NULL,
  `uploadeddate` datetime NOT NULL,
  PRIMARY KEY (`uploadfile_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;