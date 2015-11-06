DELIMITER //
DROP PROCEDURE IF EXISTS contactus //
CREATE PROCEDURE contactus (IN name VARCHAR(128),IN email VARCHAR(128),IN phone VARCHAR(20),IN message VARCHAR(2000))
BEGIN

	DECLARE return_value INT;
	SET autocommit = 0;
	SET return_value := 0;
	
		IF (name != ' ' AND email != ' ' AND phone != ' ' AND message != ' ' )
		THEN
		
		START TRANSACTION ;

		INSERT  INTO fn_contactus
        ( contact_name
        , contact_help
        , contact_email
        , contact_phone
        )
        SELECT  name
              , message
              , email
              , phone;
              
        SET return_value := 1;
        
        ELSE
        	SIGNAL SQLSTATE '45001' 
			SET MYSQL_ERRNO = 2011; 
        END IF;
        
	IF (return_value = 1)
	THEN
       	COMMIT;
    ELSE
	    ROLLBACK;
    END IF;
           
END //
DELIMITER //