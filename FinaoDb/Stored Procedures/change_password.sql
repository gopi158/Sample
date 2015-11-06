DELIMITER //
DROP PROCEDURE IF EXISTS change_password //
CREATE PROCEDURE change_password (IN emailid VARCHAR(128), IN oldpassword VARCHAR(128), IN newpassword VARCHAR(128),IN confirmpassword VARCHAR(128), IN user_id INT)
    BEGIN
    
	DECLARE return_value INT;
	DECLARE pasword VARCHAR(128); 
	SET autocommit = 0;
    
	IF EXISTS (SELECT userid FROM fn_users WHERE userid = user_id AND email= emailid)
		THEN
       			IF ( newpassword = confirmpassword ) 
       	         	THEN
	       			SELECT password
      	                	FROM    fn_users NOLOCK 
       	                	WHERE   email = emailid AND userid = user_id LIMIT 1 INTO pasword;
      	                
	        		IF ( oldpassword = pasword ) 
     		  		THEN 
					START TRANSACTION ;
		  			UPDATE  fn_users
        				SET     password = newpassword	
        				WHERE   email = emailid;
					SET return_value:= 1;
                  		ELSE
					SIGNAL SQLSTATE '45001' SET 
      					MYSQL_ERRNO = 2003,
      					MESSAGE_TEXT = 'Old password does not match!';                         
        	  		END IF ;
        		ELSE
				SIGNAL SQLSTATE '45001' SET 
      				MYSQL_ERRNO = 2002,
      				MESSAGE_TEXT = 'New password and confirm password are not same!';                         
        	        END IF ;
		ELSE
			SIGNAL SQLSTATE '45001' SET 
      			MYSQL_ERRNO = 2001,
      			MESSAGE_TEXT = 'User does not exist!'; 
		END IF;
        
	IF (return_value = 1)then
        	COMMIT;
		SELECT user_id AS id;
        ELSE
	        ROLLBACK;
        END IF;
	END  //
DELIMITER //
