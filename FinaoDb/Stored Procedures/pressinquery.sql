DELIMITER //
DROP PROCEDURE IF EXISTS pressinquery //
CREATE PROCEDURE pressinquery (IN email_id VARCHAR(128), IN titles VARCHAR(128), IN outlet_name VARCHAR(128),
							IN websites VARCHAR(128), IN f_name VARCHAR(128), IN l_name VARCHAR(128), IN phone_no VARCHAR(20), 
							IN topics VARCHAR(200), IN dead_line VARCHAR(200), IN rfiinperson INT, IN rfiphone INT, IN rfiemail INT)
BEGIN

	DECLARE return_value INT;
	SET autocommit = 0;
	SET return_value := 0;

	IF (email_id != ' ' AND titles != ' ' AND outlet_name != ' ' AND websites != ' ' AND f_name != ' ' AND l_name != ' ' AND phone_no != ' ' 
		AND topics != ' ' AND dead_line != ' ' AND ((rfiinperson > 0) OR (rfiphone > 0 ) OR (rfiemail > 0 ))
		)
		THEN
		
		START TRANSACTION ;
		
        INSERT  INTO pressinqueries
                ( fname
                , lname  
                , title
                , outletname
                , website              
                , email
                , phone
                , topic
                , deadline
				, rfi_inperson 
				, rfi_phone 
				, rfi_email 
                )
                SELECT  f_name
                      , l_name
                      , titles
                      , outlet_name
                      , websites
                      , email_id
                      , phone_no
                      , topics
                      , dead_line
                      , rfiinperson
                      , rfiphone
                      , rfiemail;
                    
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
