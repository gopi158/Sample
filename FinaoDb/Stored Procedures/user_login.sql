DELIMITER //
DROP PROCEDURE IF EXISTS user_login //
CREATE PROCEDURE user_login (IN passwrd VARCHAR(128), IN e_mail VARCHAR(128))
BEGIN
	
	DECLARE u_id INT;

	IF (passwrd != ' ' AND e_mail != ' ')
	THEN
		
		SELECT  userid
		FROM    fn_users
		WHERE   email = e_mail
				AND password = passwrd
				AND status = 1 INTO u_id;

		IF (SELECT userid FROM fn_users WHERE userid = u_id)
			THEN
					SELECT  usr.fname
						  , usr.lname
						  , usr.userid
						  , profile.mystory
						  , profile.profile_bg_image
						  , profile.profile_image
					FROM    fn_users usr
							INNER JOIN fn_user_profile profile ON usr.userid = profile.user_id
																  AND usr.userid = u_id;
			ELSE
				SIGNAL SQLSTATE '45001' 
				SET MYSQL_ERRNO = 2001; 
			END IF;
	ELSE
		SIGNAL SQLSTATE '45001' 
		SET MYSQL_ERRNO = 2004; 
	END IF;
END //
DELIMITER //