DELIMITER //
DROP PROCEDURE IF EXISTS createpost //
CREATE PROCEDURE `createpost`(
      IN finao_id INT
    , IN upload_type INT
    , IN user_id INT
    , IN fname VARCHAR(2000)
    , IN upload_path VARCHAR(200)
    , IN upload_srcetype INT
    , IN uploadfilename VARCHAR(1000)
    , IN videlurl VARCHAR(2000)
    )
BEGIN

	DECLARE return_value INT;
	DECLARE u_sourcetype INT;
	DECLARE u_type INT;
	SET autocommit = 0;
	SET return_value := 0;
	
	
	IF (upload_type = 0)
	THEN
		SET u_type := 62;
	END IF;
	
	IF (upload_type = 1)
	THEN
		SET u_type := 34;
	END IF;
	
	IF (upload_type = 2)
	THEN
		SET u_type := 35;
	END IF;

	IF (upload_srcetype = 0)
	THEN
		SET u_sourcetype := 37;
	END IF;
	
	IF (upload_srcetype = 1)
	THEN
		SET u_sourcetype := 36;
	END IF;

	IF EXISTS (SELECT user_finao_id FROM fn_user_finao WHERE user_finao_id = finao_id AND userid = user_id AND finao_activestatus = 1)
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
			, video_embedurl
			)
			SELECT u_type
				, fname
				, uploadfilename
				, upload_path
				, u_sourcetype
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
				, NULL
				, videlurl;
				
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