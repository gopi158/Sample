DELIMITER //
DROP PROCEDURE IF EXISTS forgotpassword //
CREATE PROCEDURE forgotpassword (IN e_mail VARCHAR(128), IN new_activkey VARCHAR(128))
BEGIN
	IF (e_mail != ' ' AND new_activkey != ' ')
		THEN
			IF EXISTS (SELECT userid FROM fn_users WHERE email = e_mail)
				THEN
					SET SQL_SAFE_UPDATES := 0;
					UPDATE fn_users 
					SET activkey= new_activkey
					WHERE email= e_mail;
					
					SELECT fname, lname FROM fn_users WHERE email = e_mail;
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