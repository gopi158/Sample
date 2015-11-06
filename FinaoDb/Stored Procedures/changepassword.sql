DELIMITER //
DROP PROCEDURE IF EXISTS changepassword //
CREATE PROCEDURE changepassword (IN u_name VARCHAR(256), IN oldpassword VARCHAR(128), IN newpassword VARCHAR(128), IN confirmpassword VARCHAR(128), IN e_mail VARCHAR(128))
BEGIN

	DECLARE ids INT;
	
	IF (u_name != ' ' AND oldpassword != ' ' AND newpassword != ' ' AND confirmpassword != ' ' AND e_mail != ' ')
		THEN
		
		IF u_name > 0 
		THEN
			SET ids := u_name;
		ELSE
			SELECT userid FROM fn_users WHERE uname = u_name INTO ids;	
		END IF;
		
			IF EXISTS (SELECT userid FROM fn_users WHERE email = e_mail AND userid = ids AND password = oldpassword)
				THEN 
					IF (newpassword = confirmpassword)
						THEN 
							SET SQL_SAFE_UPDATES := 0;
							UPDATE fn_users
							SET password = newpassword
							WHERE email = e_mail AND userid = ids;
							
							SELECT megeid FROM fn_users WHERE userid = ids;
					ELSE
						SIGNAL SQLSTATE '45001' 
						SET MYSQL_ERRNO = 2002; 
					END IF;
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