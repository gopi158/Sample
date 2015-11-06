DELIMITER //
DROP PROCEDURE IF EXISTS reset_password //
CREATE PROCEDURE reset_password ( IN newpassword VARCHAR(128), IN activ_key VARCHAR(128))
BEGIN
	IF (newpassword != ' ' AND activ_key != ' ')
	THEN
		IF EXISTS (SELECT userid FROM fn_users WHERE activkey = activ_key)
			THEN
				SET SQL_SAFE_UPDATES := 0;
				UPDATE fn_users 
				SET password = newpassword
				WHERE activkey = activ_key;
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