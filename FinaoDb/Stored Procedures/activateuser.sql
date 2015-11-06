DELIMITER //
DROP PROCEDURE IF EXISTS activateuser //
CREATE PROCEDURE activateuser (IN active_key VARCHAR(128))
BEGIN
	IF active_key != ' '
	THEN
		IF EXISTS (SELECT userid FROM fn_users WHERE activkey = active_key)
		THEN
			SET SQL_SAFE_UPDATES := 0;
			UPDATE fn_users
			SET status = 1
			WHERE activkey = active_key;
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