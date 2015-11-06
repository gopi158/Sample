DELIMITER //
DROP PROCEDURE IF EXISTS keepmeposted //
CREATE PROCEDURE keepmeposted (IN email_id VARCHAR(128), IN mob VARCHAR(20), IN ipaddress VARCHAR(100))
BEGIN
	
	IF email_id = NULL 
	THEN 
		SET email_id := ' ';
	END IF;
	
	IF mob = NULL 
	THEN 
		SET mob := ' ';
	END IF;
		
		INSERT  INTO splash_details
        		( email
        		, phone_num
        		, ip
        		, date
        		)
		VALUES  ( email_id
        		, mob
        		, ipaddress
        		, UTC_TIMESTAMP()
        		);


END //
DELIMITER //