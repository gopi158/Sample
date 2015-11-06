DELIMITER //
DROP PROCEDURE IF EXISTS createpost //
CREATE PROCEDURE `createpost`(
      IN finao_id INT
    , IN upload_type INT
    , IN user_id INT
    , IN fname VARCHAR(2000)
    , IN upload_path VARCHAR(200)
    , IN upload_srcetype INT
    , IN uploadfilename VARCHAR(250)
    )
BEGIN

	DECLARE return_value INT;
	SET autocommit = 0;
	SET return_value := 0;

	IF EXISTS (SELECT user_finao_id FROM fn_user_finao WHERE user_finao_id = finao_id AND userid = user_id AND 				finao_activestatus = 1)
	THEN		
		START TRANSACTION ;

		INSERT INTO fn_uploaddetails
			( uploadtype
			, upload_text
			, uploadfile_name
			, uploadfile_path
			, upload_sourcetype
			, upload_sourceid
			, uploadedby
			, uploadeddate
			, status
			, updatedby
			, updateddate
			, caption
			, videoid
			, videostatus
			, video_img
			, video_caption
			)
			SELECT upload_type
				, fname
				, uploadfilename
				, upload_path
				, upload_srcetype
				, finao_id
				, user_id
				, UTC_TIMESTAMP( )
				, 1
				, user_id
				, UTC_TIMESTAMP( )
				, NULL
				, NULL
				, NULL
				, NULL
				, NULL;
				
		SET return_value := 1;

		SELECT  MAX(uploaddetail_id) AS uploadid
		FROM    fn_uploaddetails;
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