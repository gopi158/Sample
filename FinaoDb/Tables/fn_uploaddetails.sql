CREATE TABLE IF NOT EXISTS `fn_uploaddetails` (
  `uploaddetail_id` int(11) NOT NULL AUTO_INCREMENT,
  `uploadtype` int(11) NOT NULL,
  `upload_text` varchar(250) DEFAULT NULL,
  `uploadfile_name` varchar(150) NOT NULL,
  `uploadfile_path` varchar(150) NOT NULL,
  `upload_sourcetype` int(11) NOT NULL,
  `upload_sourceid` int(11) NOT NULL,
  `uploadedby` int(11) NOT NULL,
  `uploadeddate` datetime NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `updatedby` int(11) NOT NULL,
  `updateddate` datetime NOT NULL,
  `caption` varchar(100) DEFAULT NULL,
  `video_caption` varchar(100) DEFAULT NULL,
  `videoid` varchar(20) DEFAULT NULL,
  `videostatus` varchar(20) DEFAULT NULL,
  `video_img` varchar(255) DEFAULT NULL,
  `video_embedurl` varchar(4000) DEFAULT NULL,
  `explore_finao` tinyint(1) DEFAULT NULL,
  `trending` int(10) DEFAULT NULL,
  `winner` int(11) DEFAULT NULL,
  PRIMARY KEY (`uploaddetail_id`),
  KEY `fk_upload_sourcetype` (`upload_sourcetype`),
  KEY `fk_upload_type` (`uploadtype`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4598 ;