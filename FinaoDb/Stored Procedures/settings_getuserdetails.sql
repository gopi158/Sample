DELIMITER //
DROP PROCEDURE IF EXISTS settings_getuserdetails //
CREATE PROCEDURE settings_getuserdetails ( IN user_id INT )
    BEGIN
	IF EXISTS (SELECT userid FROM fn_users WHERE userid = user_id)
	THEN
       		 SELECT  CONCAT_WS (' ',user.fname, user.lname) AS uname
        	      , user.email
        	      , user.fname
        	      , user.lname
        	      , profile.profile_image
        	      , profile.profile_bg_image
        	      , profile.mystory
        	      , profile.user_profile_msg
        	FROM    fn_users user 
        	        INNER JOIN fn_user_profile profile ON user.userid = profile.user_id
        	WHERE   user.userid = userid;
	ELSE
		SIGNAL SQLSTATE '45001' SET 
 		MYSQL_ERRNO = 2001,
   		MESSAGE_TEXT = 'User does not exist!'; 
	END IF;
        
    END //
DELIMITER //
