DROP PROCEDURE IF EXISTS `User_Delete_Procedure`;
DELIMITER ;;
CREATE DEFINER=`root`@`10.208.143.110` PROCEDURE `User_Delete_Procedure`(IN `User_Id_To_Delete` INT)
BEGIN 

	DELETE FROM fn_aweber_log WHERE email = (SELECT distinct email FROM fn_users WHERE userid = User_Id_To_Delete);
	DELETE FROM fn_uploaddetails WHERE uploadedby = User_Id_To_Delete;
	DELETE FROM fn_tracking WHERE tracked_userid = User_Id_To_Delete;
	DELETE FROM fn_tracking WHERE tracker_userid = User_Id_To_Delete;
	 
	DELETE FROM fn_trackingnotifications WHERE createdby = User_Id_To_Delete;
	DELETE FROM fn_trackingnotifications WHERE tracker_userid = User_Id_To_Delete;
	 
	 
	DELETE FROM fn_user_finao_tile WHERE userid = User_Id_To_Delete;
	DELETE FROM fn_user_finao WHERE userid = User_Id_To_Delete;
	DELETE FROM fn_user_profile WHERE user_id = User_Id_To_Delete;
	DELETE FROM fn_invite_friend WHERE invited_by_user_id = User_Id_To_Delete;
	DELETE FROM fn_users WHERE userid = User_Id_To_Delete;
	DELETE FROM fn_tilesinfo WHERE updatedby = User_Id_To_Delete;
	
	DELETE FROM `fn_user_group` WHERE `updatedby` = User_Id_To_Delete;
	DELETE FROM `fn_group_tracking` WHERE `tracker_userid` = User_Id_To_Delete;
	DELETE FROM `fn_groupnotifications` WHERE `updateby` = User_Id_To_Delete;
	DELETE FROM `fn_group_announcement` WHERE `createdby` = User_Id_To_Delete;
	DELETE FROM `fn_video_vote` WHERE `voter_userid` = User_Id_To_Delete;
	DELETE FROM `fn_video_userinfo` WHERE `userid` = User_Id_To_Delete;
	
END
;;
DELIMITER ;
