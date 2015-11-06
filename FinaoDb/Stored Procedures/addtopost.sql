DELIMITER //
DROP PROCEDURE IF EXISTS addtopost //
CREATE PROCEDURE addtopost (IN type INT, IN imgname VARCHAR(128), IN f_id INT, IN u_id INT)
BEGIN

	DECLARE return_value INT;
	SET autocommit = 0;
	SET return_value := 0;
	
		IF EXISTS (SELECT user_finao_id FROM fn_user_finao WHERE user_finao_id = f_id AND userid = u_id AND finao_activestatus = 1)
		THEN	
			IF (type = 34 OR type = 35)
			THEN
			START TRANSACTION ;

			INSERT INTO fn_uploaddetails
			( uploadtype
			, uploadfile_name
			, upload_sourcetype
			, upload_sourceid
			, uploadedby
			, uploadeddate
			, status
			, updatedby
			, updateddate
			)
			SELECT type
				, imgname
				, 37
				, f_id
				, u_id
				, UTC_TIMESTAMP( )
				, 1
				, u_id
				, UTC_TIMESTAMP( );
		
				SET return_value := 1;
		
		SELECT  MAX(uploaddetail_id) AS uploadid
		FROM    fn_uploaddetails;
		
		END IF;
		
	ELSE
		SIGNAL SQLSTATE '45001' SET 
      		MYSQL_ERRNO = 2009;
	END IF;

IF (return_value = 1)
	THEN
        	COMMIT;
        ELSE
	        ROLLBACK;
        END IF;

END //
DELIMITER //