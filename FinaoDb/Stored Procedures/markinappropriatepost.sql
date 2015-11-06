DELIMITER //
DROP PROCEDURE IF EXISTS markinappropriatepost
CREATE PROCEDURE `markinappropriatepost`(
      IN userpost_id INT
    , IN user_id INT
    )
BEGIN
	
	DECLARE tileid INT;
	DECLARE finaoid INT;
	DECLARE userid1 INT;
	DECLARE return_value INT;
	DECLARE trackingnotificationid INT;
	SET autocommit = 0;
	SET return_value := 0;
	
	IF EXISTS (SELECT upload_sourceid FROM fn_uploaddetails WHERE uploaddetail_id = userpost_id AND status =1)
	THEN	
		IF NOT EXISTS (SELECT inappropriatepostid FROM inappropriatepost WHERE userpostid = userpost_id AND flagginguserid = user_id)
		THEN
		
			SELECT DISTINCT
					uploadedby
			FROM    fn_uploaddetails
			WHERE   uploaddetail_id = userpost_id  INTO userid1;
			
			SELECT DISTINCT
					upload_sourceid
			FROM    fn_uploaddetails
			WHERE   uploaddetail_id = userpost_id INTO finaoid;
			
			SELECT DISTINCT
					tile_id
			FROM    fn_user_finao_tile
			WHERE   userid = userid1
			AND finao_id = finaoid INTO tileid;
			
			
			SELECT DISTINCT
					notification.trackingnotification_id
			FROM    fn_trackingnotifications notification
					INNER JOIN fn_uploaddetails upload ON notification.finao_id = upload.upload_sourceid
														  AND upload.uploadedby = userid1
														  AND notification.updateby = user_id
			ORDER BY notification.trackingnotification_id DESC
			LIMIT 1 INTO trackingnotificationid;

			START TRANSACTION ;

        		INSERT  INTO inappropriatepost
        		        ( userpostid
        		        , flagginguserid
        		        , isactive
        		        , modification
        		        , creation
						, notificationid
        		        )
        		        SELECT  userpost_id
        		              , user_id
        		              , 0
        		              , UTC_TIMESTAMP( )
        		              , UTC_TIMESTAMP( )
							  , trackingnotificationid;

			SET return_value := 1;
	
        		SELECT  MAX(inappropriatepostid) AS inappropriatepostid
        		FROM    inappropriatepost;
		ELSE
			SIGNAL SQLSTATE '45001' SET 
      			MYSQL_ERRNO = 2007;
		END IF;
	ELSE
		SIGNAL SQLSTATE '45001' SET 
      		MYSQL_ERRNO = 2005;
	END IF;

	IF (return_value = 1)
	THEN
        	COMMIT;
        ELSE
	        ROLLBACK;
        END IF;
     END //
 DELIMITER //