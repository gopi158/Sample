DELIMITER //
DROP PROCEDURE IF EXISTS `cleansingleusersdetails`//
CREATE PROCEDURE `cleansingleusersdetails`(IN id INT)
BEGIN
	
	IF EXISTS (SELECT userid FROM fn_users WHERE userid = id)
	THEN
			
		DELETE  FROM fn_user_profile
		WHERE   user_id = id;
		
		DELETE  FROM fn_user_finao_tile
		WHERE   userid = id;
				
		SET SQL_SAFE_UPDATES = 0;
		DELETE  FROM fn_user_finao
		WHERE   userid = id;

		SET SQL_SAFE_UPDATES = 0;
		DELETE  FROM fn_users
		WHERE   userid = id;
		
		DELETE  FROM fn_trackingnotifications
		WHERE   tracker_userid = id;
		
		DELETE  FROM fn_uploaddetails
		WHERE   uploadedby = id;

		DELETE  FROM inappropriatepost
		WHERE   userpostid = id;

		DELETE  FROM userfollowers
		WHERE   userid = id;
	
	ELSE
		SIGNAL SQLSTATE '45001' 
		SET MYSQL_ERRNO = 2001; 
	END IF;
END //
DELIMITER //