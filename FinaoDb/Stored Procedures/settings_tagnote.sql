DELIMITER //
DROP PROCEDURE IF EXISTS  settings_tagnote //
CREATE PROCEDURE  settings_tagnote (IN u_name VARCHAR(256))
BEGIN

	DECLARE user_id INT;
	
	IF u_name != ' '
	THEN
		IF u_name > 0 
		THEN
			SET user_id := u_name;
		ELSE
			SELECT userid FROM fn_users WHERE uname = u_name INTO user_id;	
		END IF;
	
		IF EXISTS (SELECT userid FROM fn_users WHERE userid = user_id)
			THEN
				SELECT mageid FROM fn_users WHERE userid = user_id;
			ELSE
				SIGNAL SQLSTATE '45001' 
				SET	MYSQL_ERRNO = 2001;	
			END IF;
	ELSE 
		SIGNAL SQLSTATE '45001' 
		SET	MYSQL_ERRNO = 2004;	
	END IF;
	
END //
DELIMITER //