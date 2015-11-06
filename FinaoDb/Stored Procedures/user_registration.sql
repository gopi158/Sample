DELIMITER //
DROP PROCEDURE IF EXISTS user_registration //
CREATE PROCEDURE user_registration ( IN psswrd VARCHAR(128), IN e_mail VARCHAR(128), IN f_name VARCHAR(128), IN l_name VARCHAR(128), IN mage_id VARCHAR(128), IN activ_key VARCHAR(128))
BEGIN

	DECLARE u_name VARCHAR(256);
	DECLARE total INT;

	IF (  psswrd != ' ' AND e_mail != ' ' AND f_name != ' ' AND l_name !=  ' ')
		THEN
		
		SELECT  COUNT(userid)
		FROM    fn_users
		WHERE  uname LIKE CONCAT_WS('.', f_name, l_name, '%') INTO total;
	
		SET total := total + 1;
		
		SET u_name = CONCAT_WS('.',f_name, l_name, total);
		
			INSERT  INTO fn_users
					( password
					, email
					, activkey
					, fname
					, lname
					, usertypeid
					, status
					, createtime
					, mageid
					, uname
					)
					SELECT  psswrd
						  , e_mail
						  , activ_key
						  , f_name
						  , l_name
						  , 64
						  , 0
						  , UTC_TIMESTAMP()
						  , mage_id
						  , u_name;
		
		ELSE
			SIGNAL SQLSTATE '45001' 
			SET MYSQL_ERRNO = 2004; 
		END IF;
END //
DELIMITER //