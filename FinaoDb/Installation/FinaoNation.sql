-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 23, 2014 at 10:18 AM
-- Server version: 5.5.24-log
-- PHP Version: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `preprod`
--

-- --------------------------------------------------------

--
-- Table structure for table `fn_aweber_log`
--

CREATE TABLE IF NOT EXISTS `fn_aweber_log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) DEFAULT NULL,
  `flag` varchar(100) DEFAULT '0',
  `status` varchar(100) DEFAULT '0',
  `uid` varchar(20) NOT NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=627 ;

-- --------------------------------------------------------

--
-- Table structure for table `fn_blogs`
--

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

-- --------------------------------------------------------

--
-- Table structure for table `fn_blogs_like`
--

CREATE TABLE IF NOT EXISTS `fn_blogs_like` (
  `blog_like_id` int(11) NOT NULL AUTO_INCREMENT,
  `blog_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `like` int(5) NOT NULL,
  `rate` int(5) NOT NULL,
  PRIMARY KEY (`blog_like_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `fn_blogs_tags`
--

CREATE TABLE IF NOT EXISTS `fn_blogs_tags` (
  `blogs_tags_id` int(11) NOT NULL AUTO_INCREMENT,
  `blog_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  PRIMARY KEY (`blogs_tags_id`),
  KEY `fk_blogs_tags_blogid` (`blog_id`),
  KEY `fk_blogs_tags_tagid` (`tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `fn_blog_tags`
--

CREATE TABLE IF NOT EXISTS `fn_blog_tags` (
  `tag_id` int(11) NOT NULL AUTO_INCREMENT,
  `tag_name` varchar(150) NOT NULL,
  `tag_status` int(11) NOT NULL,
  `createdate` datetime NOT NULL,
  `createdby` int(11) NOT NULL,
  PRIMARY KEY (`tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `fn_city_zip`
--

CREATE TABLE IF NOT EXISTS `fn_city_zip` (
  `city_zip_id` int(11) NOT NULL AUTO_INCREMENT,
  `city` varchar(100) NOT NULL,
  `zipcode` varchar(5) NOT NULL,
  `state` varchar(3) NOT NULL,
  `school_district` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`city_zip_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `fn_comments`
--

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

-- --------------------------------------------------------

--
-- Table structure for table `fn_contactus`
--

CREATE TABLE IF NOT EXISTS `fn_contactus` (
  `contact_id` int(11) NOT NULL AUTO_INCREMENT,
  `contact_name` varchar(50) DEFAULT NULL,
  `contact_company` varchar(50) DEFAULT NULL,
  `contact_help` varchar(4000) NOT NULL,
  `contact_email` varchar(50) DEFAULT NULL,
  `contact_phone` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`contact_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `fn_contentnote`
--

CREATE TABLE IF NOT EXISTS `fn_contentnote` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- Table structure for table `fn_feedback`
--

CREATE TABLE IF NOT EXISTS `fn_feedback` (
  `feedback_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(25) NOT NULL,
  `feedback_mesg` varchar(250) NOT NULL,
  `user_email` varchar(25) NOT NULL,
  `created_date` datetime NOT NULL,
  PRIMARY KEY (`feedback_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `fn_groupnotifications`
--

CREATE TABLE IF NOT EXISTS `fn_groupnotifications` (
  `trackingnotification_id` int(11) NOT NULL AUTO_INCREMENT,
  `tracker_userid` int(11) NOT NULL,
  `group_id` int(22) NOT NULL,
  `finao_id` int(11) DEFAULT NULL,
  `journal_id` int(11) DEFAULT NULL,
  `notification_action` int(11) NOT NULL,
  `updateby` int(11) NOT NULL,
  `updateddate` datetime NOT NULL,
  `createdby` int(11) NOT NULL,
  `createddate` datetime NOT NULL,
  PRIMARY KEY (`trackingnotification_id`),
  KEY `fk_tracknoti_trackerid` (`tracker_userid`),
  KEY `fk_tracknoti_tileid` (`group_id`),
  KEY `fk_tracknoti_updatedby` (`updateby`),
  KEY `fk_tracknoti_createdby` (`createdby`),
  KEY `fk_tracknoti_notifyaction` (`notification_action`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=38 ;

-- --------------------------------------------------------

--
-- Table structure for table `fn_group_announcement`
--

CREATE TABLE IF NOT EXISTS `fn_group_announcement` (
  `anno_id` int(11) NOT NULL AUTO_INCREMENT,
  `uploadsourcetype` int(255) DEFAULT NULL,
  `uploadsourceid` int(255) DEFAULT NULL,
  `announcement` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `createdby` int(100) DEFAULT NULL,
  `createddate` datetime DEFAULT NULL,
  `status` int(10) DEFAULT NULL,
  PRIMARY KEY (`anno_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=16 ;

-- --------------------------------------------------------

--
-- Table structure for table `fn_group_tracking`
--

CREATE TABLE IF NOT EXISTS `fn_group_tracking` (
  `tracking_id` int(11) NOT NULL AUTO_INCREMENT,
  `tracker_userid` int(50) DEFAULT NULL,
  `tracked_userid` int(50) DEFAULT NULL,
  `tracked_groupid` int(50) DEFAULT NULL,
  `visible` int(11) NOT NULL DEFAULT '0' COMMENT '0-visible 1-not visible',
  `createddate` date DEFAULT NULL,
  `status` int(5) DEFAULT NULL,
  `view_status` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`tracking_id`),
  KEY `fk_TrackGroup` (`tracked_groupid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Table structure for table `fn_images`
--

CREATE TABLE IF NOT EXISTS `fn_images` (
  `image_id` int(11) NOT NULL AUTO_INCREMENT,
  `upload_id` int(255) DEFAULT NULL,
  `uploadfile_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `uploadfile_path` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `caption` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `uploadedby` int(100) DEFAULT NULL,
  `uploadeddate` datetime DEFAULT NULL,
  `updatedby` int(100) DEFAULT NULL,
  `updateddate` datetime DEFAULT NULL,
  `status` int(10) DEFAULT NULL,
  `trending` int(10) DEFAULT NULL,
  PRIMARY KEY (`image_id`),
  KEY `upload_id` (`upload_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=91 ;

-- --------------------------------------------------------

--
-- Table structure for table `fn_invite_friend`
--

CREATE TABLE IF NOT EXISTS `fn_invite_friend` (
  `invite_friend_id` int(11) NOT NULL AUTO_INCREMENT,
  `source` varchar(50) DEFAULT NULL,
  `invitee_social_network_id` varchar(50) DEFAULT NULL,
  `invited_by_social_network_id` varchar(50) DEFAULT NULL,
  `invited_by_user_id` int(11) NOT NULL,
  `invited_request_id` varchar(50) DEFAULT NULL,
  `invited_date` datetime NOT NULL,
  `status` int(11) NOT NULL,
  `invitee_email` varchar(255) DEFAULT NULL,
  `invitee_user_type` int(11) NOT NULL,
  PRIMARY KEY (`invite_friend_id`),
  KEY `fk_inviteby_user` (`invited_by_user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=515 ;

-- --------------------------------------------------------

--
-- Table structure for table `fn_like`
--

CREATE TABLE IF NOT EXISTS `fn_like` (
  `like_id` int(11) NOT NULL AUTO_INCREMENT,
  `like_type` varchar(50) NOT NULL,
  `source_like_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_date` datetime DEFAULT NULL,
  PRIMARY KEY (`like_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `fn_logactivities`
--

CREATE TABLE IF NOT EXISTS `fn_logactivities` (
  `logactivity_id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `user_sessionid` int(11) NOT NULL,
  `logindatetime` datetime NOT NULL,
  `logoutdatetime` datetime NOT NULL,
  PRIMARY KEY (`logactivity_id`),
  KEY `fk_log_userid` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `fn_lookups`
--

CREATE TABLE IF NOT EXISTS `fn_lookups` (
  `lookup_id` int(11) NOT NULL AUTO_INCREMENT,
  `lookup_name` varchar(150) NOT NULL,
  `lookup_type` varchar(150) NOT NULL,
  `lookup_status` int(11) NOT NULL,
  `lookup_parentid` int(11) DEFAULT '0',
  `createdate` datetime NOT NULL,
  `updateddate` datetime DEFAULT NULL,
  PRIMARY KEY (`lookup_id`),
  KEY `ind_lookup_year` (`lookup_name`,`lookup_type`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=77 ;

-- --------------------------------------------------------

--
-- Table structure for table `fn_mailbox_conversation`
--

CREATE TABLE IF NOT EXISTS `fn_mailbox_conversation` (
  `conversation_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `initiator_id` int(10) NOT NULL,
  `interlocutor_id` int(10) NOT NULL,
  `subject` varchar(100) NOT NULL DEFAULT '',
  `bm_read` tinyint(3) NOT NULL DEFAULT '0',
  `bm_deleted` tinyint(3) NOT NULL DEFAULT '0',
  `modified` int(10) unsigned NOT NULL,
  `is_system` enum('yes','no') NOT NULL DEFAULT 'no',
  `initiator_del` tinyint(1) unsigned DEFAULT '0',
  `interlocutor_del` tinyint(1) unsigned DEFAULT '0',
  PRIMARY KEY (`conversation_id`),
  KEY `initiator_id` (`initiator_id`),
  KEY `interlocutor_id` (`interlocutor_id`),
  KEY `conversation_ts` (`modified`),
  KEY `subject` (`subject`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `fn_notes`
--

CREATE TABLE IF NOT EXISTS `fn_notes` (
  `note_id` int(11) NOT NULL AUTO_INCREMENT,
  `tracker_userid` int(55) NOT NULL,
  `tracked_userid` int(55) NOT NULL,
  `upload_sourceid` int(55) NOT NULL,
  `upload_sourcetype` int(11) NOT NULL,
  `view_status` int(10) NOT NULL DEFAULT '0',
  `block_status` int(10) NOT NULL DEFAULT '0',
  `contentnote_id` int(10) NOT NULL,
  `createddate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`note_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=57 ;

-- --------------------------------------------------------

--
-- Table structure for table `fn_profanity_words`
--

CREATE TABLE IF NOT EXISTS `fn_profanity_words` (
  `badwords_id` int(11) NOT NULL AUTO_INCREMENT,
  `badword` varchar(100) NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1',
  PRIMARY KEY (`badwords_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=467 ;

-- --------------------------------------------------------

--
-- Table structure for table `fn_profileview`
--

CREATE TABLE IF NOT EXISTS `fn_profileview` (
  `profileview_id` int(11) NOT NULL AUTO_INCREMENT,
  `viewer_userid` int(11) NOT NULL,
  `viewed_userid` int(11) NOT NULL,
  `user_sessionid` varchar(20) NOT NULL,
  `createddate` datetime DEFAULT NULL,
  PRIMARY KEY (`profileview_id`),
  KEY `fk_profview_vieweruusr` (`viewer_userid`),
  KEY `fk_profview_viewedusr` (`viewed_userid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `fn_tags`
--

CREATE TABLE IF NOT EXISTS `fn_tags` (
  `user_tag_id` int(11) NOT NULL AUTO_INCREMENT,
  `tag_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  PRIMARY KEY (`user_tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `fn_tilesinfo`
--

CREATE TABLE IF NOT EXISTS `fn_tilesinfo` (
  `tilesinfo_id` int(11) NOT NULL AUTO_INCREMENT,
  `tile_id` int(11) NOT NULL,
  `tilename` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `tile_imageurl` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `temp_tile_imageurl` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Is_customtile` tinyint(1) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '0',
  `createdby` int(11) NOT NULL,
  `createddate` datetime NOT NULL,
  `updatedby` int(11) NOT NULL,
  `updateddate` datetime NOT NULL,
  PRIMARY KEY (`tilesinfo_id`),
  KEY `fk_tileinfo_createdby` (`createdby`),
  KEY `fk_tileinfo_updatedby` (`updatedby`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2023 ;

-- --------------------------------------------------------

--
-- Table structure for table `fn_tracking`
--

CREATE TABLE IF NOT EXISTS `fn_tracking` (
  `tracking_id` int(11) NOT NULL AUTO_INCREMENT,
  `tracker_userid` int(11) NOT NULL,
  `tracked_userid` int(11) NOT NULL,
  `tracked_tileid` int(11) NOT NULL,
  `view_status` int(10) NOT NULL DEFAULT '0',
  `createddate` datetime NOT NULL,
  `status` int(11) NOT NULL,
  `tracked_type` int(11) DEFAULT NULL,
  PRIMARY KEY (`tracking_id`),
  KEY `fk_track_trackerusrid` (`tracker_userid`),
  KEY `fk_track_trackedusrid` (`tracked_userid`),
  KEY `fk_track_tileid` (`tracked_tileid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2117 ;

-- --------------------------------------------------------

--
-- Table structure for table `fn_trackingnotifications`
--

CREATE TABLE IF NOT EXISTS `fn_trackingnotifications` (
  `trackingnotification_id` int(11) NOT NULL AUTO_INCREMENT,
  `tracker_userid` int(11) NOT NULL,
  `tile_id` int(11) NOT NULL,
  `finao_id` int(11) DEFAULT NULL,
  `journal_id` int(11) DEFAULT NULL,
  `notification_action` int(11) NOT NULL,
  `updateby` int(11) NOT NULL,
  `updateddate` datetime NOT NULL,
  `createdby` int(11) NOT NULL,
  `createddate` datetime NOT NULL,
  PRIMARY KEY (`trackingnotification_id`),
  KEY `fk_tracknoti_trackerid` (`tracker_userid`),
  KEY `fk_tracknoti_tileid` (`tile_id`),
  KEY `fk_tracknoti_updatedby` (`updateby`),
  KEY `fk_tracknoti_createdby` (`createdby`),
  KEY `fk_tracknoti_notifyaction` (`notification_action`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2249 ;

-- --------------------------------------------------------

--
-- Table structure for table `fn_transactionlog`
--

CREATE TABLE IF NOT EXISTS `fn_transactionlog` (
  `transactionlog_id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_descr` varchar(200) NOT NULL,
  `transaction_status` varchar(45) DEFAULT NULL,
  `transactiondate` datetime NOT NULL,
  `uploadfile_id` int(11) NOT NULL,
  PRIMARY KEY (`transactionlog_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `fn_uploaddetails`
--

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

-- --------------------------------------------------------

--
-- Table structure for table `fn_uploadfileinfo`
--

CREATE TABLE IF NOT EXISTS `fn_uploadfileinfo` (
  `uploadfile_id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(150) NOT NULL,
  `filecommments` varchar(100) DEFAULT NULL,
  `uploadedby` int(11) NOT NULL,
  `uploadeddate` datetime NOT NULL,
  PRIMARY KEY (`uploadfile_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `fn_users`
--

CREATE TABLE IF NOT EXISTS `fn_users` (
  `userid` int(11) NOT NULL AUTO_INCREMENT,
  `password` varchar(128) NOT NULL,
  `uname` varchar(55) NOT NULL,
  `email` varchar(128) NOT NULL,
  `secondary_email` varchar(128) DEFAULT NULL,
  `activkey` varchar(128) NOT NULL DEFAULT '',
  `lastvisit` int(10) NOT NULL DEFAULT '0',
  `superuser` int(1) NOT NULL DEFAULT '0',
  `profile_image` varchar(750) DEFAULT NULL,
  `fname` varchar(100) DEFAULT NULL,
  `lname` varchar(100) DEFAULT NULL,
  `gender` int(11) DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `dob` date NOT NULL,
  `age` varchar(20) DEFAULT NULL,
  `mageid` int(11) NOT NULL,
  `socialnetwork` varchar(45) DEFAULT NULL,
  `socialnetworkid` varchar(150) DEFAULT NULL,
  `usertypeid` int(11) DEFAULT NULL COMMENT '63-Web 64-Mobile',
  `status` int(1) NOT NULL DEFAULT '0',
  `zipcode` int(11) NOT NULL,
  `createtime` datetime NOT NULL,
  `createdby` int(11) NOT NULL,
  `updatedby` int(11) DEFAULT NULL,
  `updatedate` datetime DEFAULT NULL,
  `trackid` int(50) DEFAULT NULL,
  PRIMARY KEY (`userid`),
  UNIQUE KEY `email` (`email`),
  KEY `status` (`status`),
  KEY `superuser` (`superuser`),
  KEY `fk_user_gender` (`gender`),
  KEY `fk_user_type` (`usertypeid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1167 ;

-- --------------------------------------------------------

--
-- Table structure for table `fn_user_finao`
--

CREATE TABLE IF NOT EXISTS `fn_user_finao` (
  `user_finao_id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `finao_msg` varchar(200) NOT NULL,
  `finao_status_Ispublic` int(11) NOT NULL DEFAULT '0' COMMENT '0-private ,1-public',
  `finao_activestatus` int(11) NOT NULL DEFAULT '1' COMMENT '1-acitive ,2-delete',
  `IsSkipped` varchar(10) NOT NULL,
  `createddate` datetime NOT NULL,
  `updatedby` int(11) NOT NULL,
  `updateddate` datetime NOT NULL,
  `finao_status` int(11) NOT NULL,
  `Iscompleted` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0-notcompleted,1-completed',
  `Isdefault` tinyint(1) DEFAULT '0',
  `IsGroup` int(11) NOT NULL,
  `group_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`user_finao_id`),
  KEY `fk_usrtilefinao_userid` (`userid`),
  KEY `fk_usrtilefinao_updatedby` (`updatedby`),
  KEY `fk_usrfinao_status` (`finao_status`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3252 ;

-- --------------------------------------------------------

--
-- Table structure for table `fn_user_finao_journal`
--

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

-- --------------------------------------------------------

--
-- Table structure for table `fn_user_finao_tile`
--

CREATE TABLE IF NOT EXISTS `fn_user_finao_tile` (
  `user_tileid` int(11) NOT NULL AUTO_INCREMENT,
  `tile_id` int(11) NOT NULL,
  `tile_name` varchar(100) NOT NULL,
  `userid` int(11) NOT NULL,
  `finao_id` int(11) NOT NULL,
  `tile_profileImagurl` varchar(250) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `createddate` datetime NOT NULL,
  `createdby` int(11) NOT NULL,
  `updateddate` datetime NOT NULL,
  `updatedby` int(11) NOT NULL,
  `explore_finao` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`user_tileid`),
  KEY `fk_usrtile_userid` (`userid`),
  KEY `fk_usrtile_createdby` (`createdby`),
  KEY `fk_usrtile_updateby` (`updatedby`),
  KEY `fk_usrtile_finao` (`finao_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3126 ;

-- --------------------------------------------------------

--
-- Table structure for table `fn_user_group`
--

CREATE TABLE IF NOT EXISTS `fn_user_group` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `group_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `profile_image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `temp_profile_image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `profile_bg_image` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `temp_profile_bg_image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `group_status_ispublic` int(10) DEFAULT '0' COMMENT '0-Private1-Public',
  `group_activestatus` int(10) DEFAULT '0',
  `upload_status` int(10) DEFAULT NULL,
  `updatedby` int(10) DEFAULT NULL,
  `createddate` datetime NOT NULL,
  `updatedate` datetime DEFAULT NULL,
  PRIMARY KEY (`group_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=97 ;

-- --------------------------------------------------------

--
-- Table structure for table `fn_user_profile`
--

CREATE TABLE IF NOT EXISTS `fn_user_profile` (
  `user_profile_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `user_profile_msg` varchar(150) DEFAULT NULL,
  `user_location` varchar(100) DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `profile_bg_image` varchar(255) DEFAULT NULL,
  `profile_status_Ispublic` int(11) DEFAULT '0',
  `createdby` int(11) NOT NULL,
  `createddate` datetime NOT NULL,
  `updatedby` int(11) NOT NULL,
  `updateddate` datetime NOT NULL,
  `mystory` varchar(4000) DEFAULT NULL,
  `IsCompleted` varchar(10) NOT NULL,
  `temp_profile_image` varchar(255) DEFAULT NULL,
  `temp_profile_bg_image` varchar(255) DEFAULT NULL,
  `explore_finao` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`user_profile_id`),
  KEY `fn_usrprof_createdby` (`createdby`),
  KEY `fn_usrprof_updatedby` (`updatedby`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=678 ;

-- --------------------------------------------------------

--
-- Table structure for table `fn_videos`
--

CREATE TABLE IF NOT EXISTS `fn_videos` (
  `video_id` int(11) NOT NULL AUTO_INCREMENT,
  `upload_id` int(255) DEFAULT NULL,
  `videoid` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `videostatus` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `video_img` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `video_embedurl` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `caption` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `uploadedby` int(100) DEFAULT NULL,
  `uploadeddate` datetime DEFAULT NULL,
  `updatedby` int(100) DEFAULT NULL,
  `updateddate` datetime DEFAULT NULL,
  `status` int(10) DEFAULT NULL,
  `trending` int(10) DEFAULT NULL,
  PRIMARY KEY (`video_id`),
  KEY `upload_id` (`upload_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Table structure for table `fn_video_userinfo`
--

CREATE TABLE IF NOT EXISTS `fn_video_userinfo` (
  `vid` int(10) NOT NULL AUTO_INCREMENT,
  `contesttype` int(11) DEFAULT NULL,
  `userid` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `school` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `graduate` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `major` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`vid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

-- --------------------------------------------------------

--
-- Table structure for table `fn_video_vote`
--

CREATE TABLE IF NOT EXISTS `fn_video_vote` (
  `vote_id` int(11) NOT NULL AUTO_INCREMENT,
  `voter_userid` int(11) NOT NULL,
  `voted_userid` int(11) NOT NULL,
  `voted_sourceid` int(11) NOT NULL,
  `createddate` datetime NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`vote_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `fn_blogs`
--
ALTER TABLE `fn_blogs`
  ADD CONSTRAINT `fk_blog_category` FOREIGN KEY (`blog_category_id`) REFERENCES `fn_lookups` (`lookup_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_blog_userid` FOREIGN KEY (`createdby`) REFERENCES `fn_users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fn_blogs_ibfk_1` FOREIGN KEY (`blog_category_id`) REFERENCES `fn_lookups` (`lookup_id`),
  ADD CONSTRAINT `fn_blogs_ibfk_2` FOREIGN KEY (`blog_category_id`) REFERENCES `fn_lookups` (`lookup_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fn_blogs_ibfk_3` FOREIGN KEY (`createdby`) REFERENCES `fn_users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fn_blogs_ibfk_4` FOREIGN KEY (`blog_category_id`) REFERENCES `fn_lookups` (`lookup_id`);

--
-- Constraints for table `fn_comments`
--
ALTER TABLE `fn_comments`
  ADD CONSTRAINT `fn_comments_ibfk_1` FOREIGN KEY (`comment_author_id`) REFERENCES `fn_users` (`userid`),
  ADD CONSTRAINT `fn_comments_ibfk_2` FOREIGN KEY (`comment_author_id`) REFERENCES `fn_users` (`userid`);

--
-- Constraints for table `fn_invite_friend`
--
ALTER TABLE `fn_invite_friend`
  ADD CONSTRAINT `fk_inviteby_user` FOREIGN KEY (`invited_by_user_id`) REFERENCES `fn_users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fn_invite_friend_ibfk_1` FOREIGN KEY (`invited_by_user_id`) REFERENCES `fn_users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `fn_like`
--
ALTER TABLE `fn_like`
  ADD CONSTRAINT `fn_like_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `fn_users` (`userid`),
  ADD CONSTRAINT `fn_like_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `fn_users` (`userid`);

--
-- Constraints for table `fn_logactivities`
--
ALTER TABLE `fn_logactivities`
  ADD CONSTRAINT `fk_log_userid` FOREIGN KEY (`userid`) REFERENCES `fn_users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fn_logactivities_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `fn_users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `fn_profileview`
--
ALTER TABLE `fn_profileview`
  ADD CONSTRAINT `fk_profview_viewedusr` FOREIGN KEY (`viewed_userid`) REFERENCES `fn_users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_profview_vieweruusr` FOREIGN KEY (`viewer_userid`) REFERENCES `fn_users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fn_profileview_ibfk_1` FOREIGN KEY (`viewed_userid`) REFERENCES `fn_users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fn_profileview_ibfk_2` FOREIGN KEY (`viewer_userid`) REFERENCES `fn_users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `fn_tracking`
--
ALTER TABLE `fn_tracking`
  ADD CONSTRAINT `fk_track_trackedusrid` FOREIGN KEY (`tracked_userid`) REFERENCES `fn_users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_track_trackerusrid` FOREIGN KEY (`tracker_userid`) REFERENCES `fn_users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fn_tracking_ibfk_1` FOREIGN KEY (`tracked_userid`) REFERENCES `fn_users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fn_tracking_ibfk_2` FOREIGN KEY (`tracker_userid`) REFERENCES `fn_users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `fn_trackingnotifications`
--
ALTER TABLE `fn_trackingnotifications`
  ADD CONSTRAINT `fk_tracknoti_createdby` FOREIGN KEY (`createdby`) REFERENCES `fn_users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tracknoti_notifyaction` FOREIGN KEY (`notification_action`) REFERENCES `fn_lookups` (`lookup_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tracknoti_trackerid` FOREIGN KEY (`tracker_userid`) REFERENCES `fn_users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tracknoti_updatedby` FOREIGN KEY (`updateby`) REFERENCES `fn_users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fn_trackingnotifications_ibfk_1` FOREIGN KEY (`createdby`) REFERENCES `fn_users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fn_trackingnotifications_ibfk_2` FOREIGN KEY (`notification_action`) REFERENCES `fn_lookups` (`lookup_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fn_trackingnotifications_ibfk_3` FOREIGN KEY (`tracker_userid`) REFERENCES `fn_users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fn_trackingnotifications_ibfk_4` FOREIGN KEY (`updateby`) REFERENCES `fn_users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `fn_uploaddetails`
--
ALTER TABLE `fn_uploaddetails`
  ADD CONSTRAINT `fk_upload_sourcetype` FOREIGN KEY (`upload_sourcetype`) REFERENCES `fn_lookups` (`lookup_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_upload_type` FOREIGN KEY (`uploadtype`) REFERENCES `fn_lookups` (`lookup_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fn_uploaddetails_ibfk_1` FOREIGN KEY (`upload_sourcetype`) REFERENCES `fn_lookups` (`lookup_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fn_uploaddetails_ibfk_2` FOREIGN KEY (`uploadtype`) REFERENCES `fn_lookups` (`lookup_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `fn_users`
--
ALTER TABLE `fn_users`
  ADD CONSTRAINT `fk_user_gender` FOREIGN KEY (`gender`) REFERENCES `fn_lookups` (`lookup_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_user_type` FOREIGN KEY (`usertypeid`) REFERENCES `fn_lookups` (`lookup_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fn_users_ibfk_1` FOREIGN KEY (`gender`) REFERENCES `fn_lookups` (`lookup_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fn_users_ibfk_2` FOREIGN KEY (`usertypeid`) REFERENCES `fn_lookups` (`lookup_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `fn_user_finao`
--
ALTER TABLE `fn_user_finao`
  ADD CONSTRAINT `fk_usrfinao_status` FOREIGN KEY (`finao_status`) REFERENCES `fn_lookups` (`lookup_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_usrfinao_updatedby` FOREIGN KEY (`updatedby`) REFERENCES `fn_users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_usrfinao_user` FOREIGN KEY (`userid`) REFERENCES `fn_users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fn_user_finao_ibfk_1` FOREIGN KEY (`finao_status`) REFERENCES `fn_lookups` (`lookup_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fn_user_finao_ibfk_2` FOREIGN KEY (`updatedby`) REFERENCES `fn_users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fn_user_finao_ibfk_3` FOREIGN KEY (`userid`) REFERENCES `fn_users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `fn_user_finao_journal`
--
ALTER TABLE `fn_user_finao_journal`
  ADD CONSTRAINT `fk_usrfinaojou_creby` FOREIGN KEY (`createdby`) REFERENCES `fn_users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_usrfinaojou_finaoid` FOREIGN KEY (`finao_id`) REFERENCES `fn_user_finao` (`user_finao_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_usrfinaojou_updby` FOREIGN KEY (`updatedby`) REFERENCES `fn_users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fn_user_finao_journal_ibfk_1` FOREIGN KEY (`createdby`) REFERENCES `fn_users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fn_user_finao_journal_ibfk_2` FOREIGN KEY (`finao_id`) REFERENCES `fn_user_finao` (`user_finao_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fn_user_finao_journal_ibfk_3` FOREIGN KEY (`updatedby`) REFERENCES `fn_users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `fn_user_finao_tile`
--
ALTER TABLE `fn_user_finao_tile`
  ADD CONSTRAINT `fk_usrtile_createdby` FOREIGN KEY (`createdby`) REFERENCES `fn_users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_usrtile_finao` FOREIGN KEY (`finao_id`) REFERENCES `fn_user_finao` (`user_finao_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_usrtile_updateby` FOREIGN KEY (`updatedby`) REFERENCES `fn_users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_usrtile_userid` FOREIGN KEY (`userid`) REFERENCES `fn_users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fn_user_finao_tile_ibfk_1` FOREIGN KEY (`createdby`) REFERENCES `fn_users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fn_user_finao_tile_ibfk_2` FOREIGN KEY (`finao_id`) REFERENCES `fn_user_finao` (`user_finao_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fn_user_finao_tile_ibfk_3` FOREIGN KEY (`updatedby`) REFERENCES `fn_users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fn_user_finao_tile_ibfk_4` FOREIGN KEY (`userid`) REFERENCES `fn_users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `fn_user_profile`
--
ALTER TABLE `fn_user_profile`
  ADD CONSTRAINT `fn_user_profile_ibfk_1` FOREIGN KEY (`createdby`) REFERENCES `fn_users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fn_user_profile_ibfk_2` FOREIGN KEY (`updatedby`) REFERENCES `fn_users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fn_usrprof_createdby` FOREIGN KEY (`createdby`) REFERENCES `fn_users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fn_usrprof_updatedby` FOREIGN KEY (`updatedby`) REFERENCES `fn_users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
