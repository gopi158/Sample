DELIMITER //
DROP PROCEDURE IF EXISTS settings_updateuserdetails //
CREATE PROCEDURE `settings_updateuserdetails`(
      IN id INT
    , IN f_name VARCHAR(128)
    , IN pass VARCHAR(128)
    , IN image VARCHAR(255)
    , IN bnimage VARCHAR(255)
    , IN bio VARCHAR(2000)
    , IN l_name VARCHAR(128)
    )
BEGIN
	DECLARE return_value INT;
	SET return_value := 0;

	IF EXISTS (SELECT userid FROM fn_users WHERE userid = id)
	THEN
		
		IF (pass = ' ')
		THEN
		
			START TRANSACTION ;
		
			IF (image = ' ' AND bnimage = ' ')
			THEN
			
				UPDATE  fn_users
        			SET     fname = f_name
    		      	, lname = l_name
        			WHERE   userid = id;
   
  	      		UPDATE  fn_user_profile
        			SET   mystory = bio
        			WHERE   user_id = id;	
				
        	ELSEIF (image = ' ')		
				THEN
				
				UPDATE  fn_users
        			SET  fname = f_name
    		      	, lname = l_name
        			WHERE   userid = id;
   
  	      		UPDATE  fn_user_profile
        			SET    profile_bg_image = bnimage
        	      	, mystory = bio
        			WHERE   user_id = id;		
			
			ELSEIF (bnimage = ' ')
				THEN
        		UPDATE  fn_users
        			SET     fname = f_name
    		      	, lname = l_name
	              	, profile_image = image
        			WHERE   userid = id;
   
  	      		UPDATE  fn_user_profile
        			SET     profile_image = image
        	      	, mystory = bio
        			WHERE   user_id = id;	
			
			ELSE
				UPDATE  fn_users
        			SET     fname = f_name
    		      	, lname = l_name
	              	, profile_image = image
        			WHERE   userid = id;
   
  	      		UPDATE  fn_user_profile
        			SET     profile_image = image
        	      	, profile_bg_image = bnimage
        	      	, mystory = bio
        			WHERE   user_id = id;	
			END IF;
			
			SET return_value := 1;

		
		ELSEIF (pass != ' ')
			THEN
			
			START TRANSACTION ;
			
				IF (image = ' ' AND bnimage = ' ')
				THEN
				
				UPDATE  fn_users
        			SET     fname = f_name
    		      	, lname = l_name
	              	, email = emailid
	              	, password = pass
        			WHERE   userid = id;
   
        			UPDATE  fn_user_profile
        			SET   mystory = bio
        			WHERE   user_id = id;
				
			ELSEIF (image = ' ')	
				THEN
				
				UPDATE  fn_users
        			SET     fname = f_name
    		      	, lname = l_name
	              	, email = emailid
	              	, password = pass
        			WHERE   userid = id;
   
        			UPDATE  fn_user_profile
        			SET     profile_bg_image = bnimage
        	      		, mystory = bio
        			WHERE   user_id = id;
			
			ELSEIF (bnimage = ' ')
				THEN
				
				UPDATE  fn_users
        			SET     fname = f_name
    		      	, lname = l_name
	              	, email = emailid
	              	, password = pass
	              	, profile_image = image
        			WHERE   userid = id;
   
        			UPDATE  fn_user_profile
        			SET     profile_image = image
        	      		, mystory = bio
        			WHERE   user_id = id;
			
			ELSE
				UPDATE  fn_users
        			SET     fname = f_name
    		      	, lname = l_name
	              	, email = emailid
	              	, password = pass
	              	, profile_image = image
        			WHERE   userid = id;
   
        			UPDATE  fn_user_profile
        			SET   profile_image = image
        	      		, profile_bg_image = bnimage
        	      		, mystory = bio
        			WHERE   user_id = id;
			END IF;

		SET return_value := 1;

		END IF;
	ELSE
		SIGNAL SQLSTATE '45001' SET 
      		MYSQL_ERRNO = 2001;
	END IF;

	IF (return_value = 1)
	THEN
        	COMMIT;
        ELSE
	        ROLLBACK;
        END IF;
    END //
    DELIMITER //