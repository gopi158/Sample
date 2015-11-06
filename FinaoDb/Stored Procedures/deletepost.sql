DELIMITER //
DROP PROCEDURE IF EXISTS deletepost //
CREATE PROCEDURE `deletepost`(
      IN finaoid INT
    , IN userpost_id INT
    , IN user_id INT
    )
BEGIN

	DECLARE isactivepost INT;
	DECLARE return_value INT;
	SET autocommit = 0;
	SET return_value := 0;
	
 
	IF EXISTS (SELECT uploaddetail_id FROM fn_uploaddetails WHERE uploaddetail_id = userpost_id AND upload_sourceid= finaoid AND updatedby = user_id)
		THEN
			SET isactivepost := 1;
			
			IF (isactivepost = 1)
			THEN
				START TRANSACTION ;
			        UPDATE  fn_uploaddetails
			        SET     status = 0
			        WHERE uploaddetail_id = userpost_id AND upload_sourceid= finaoid AND updatedby = user_id;
				SET return_value := 1;
			ELSE
				SIGNAL SQLSTATE '45001' SET 
	      			MYSQL_ERRNO = 2006; 
			END IF;
		ELSE
		
			SIGNAL SQLSTATE '45001' 
			SET MYSQL_ERRNO = 2005; 
			
		END IF;
	IF (return_value = 1)
	THEN
        	COMMIT;
        ELSE
	        ROLLBACK;
        END IF;
    END //
    DELIMITER //