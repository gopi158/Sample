DELIMITER //
DROP PROCEDURE IF EXISTS inspiringpost //
CREATE  PROCEDURE `inspiringpost`(
      IN userpost_id INT
    , IN user_id INT
    )
BEGIN

	DECLARE tileid INT;
	DECLARE finaoid INT;
	DECLARE userid1 INT;
	DECLARE return_value INT;
	SET autocommit = 0;
	SET return_value := 0;
	
	IF EXISTS (SELECT upload_sourceid FROM fn_uploaddetails WHERE uploaddetail_id = userpost_id AND status =1)
	THEN
		IF NOT EXISTS (SELECT inspiringpostid FROM inspiringpost NOLOCK WHERE userpostid = userpost_id AND inspireduserid = user_id)
		THEN		

		SELECT DISTINCT uploadedby FROM fn_uploaddetails WHERE uploaddetail_id = userpost_id INTO userid1;
		SELECT DISTINCT upload_sourceid FROM fn_uploaddetails WHERE uploaddetail_id = userpost_id INTO finaoid;
		SELECT DISTINCT tile_id FROM fn_user_finao_tile WHERE userid = userid1 AND finao_id = finaoid INTO tileid;

			START TRANSACTION ;

			INSERT  INTO inspiringpost
        		        ( userpostid
        		        , inspireduserid
        		        , isactive
        		        , modification
        		        , creation
        		        )
        		        SELECT  userpost_id
        		              , user_id
        		              , 1
        		              , UTC_TIMESTAMP( )
        		              , UTC_TIMESTAMP( );
        		              
        	INSERT  INTO fn_tracking
        	        ( tracker_userid
        	        , tracked_userid
        	        , tracked_tileid
        	        , view_status
        	        , createddate
        	        , status
        	        , tracked_type
        	        )	 
        	        SELECT user_id
        	        		, userid1  
        	        		, tileid 
        	        		, 1
        	        		, UTC_TIMESTAMP( )
        	        		, 1
        	        		, 123;     	              
	
			INSERT  INTO fn_trackingnotifications
        		( tracker_userid
        		, tile_id
        		, finao_id
        		, journal_id
        		, notification_action
        		, updateby
        		, updateddate
        		, createdby
        		, createddate
        		, isread
        		)
	        	SELECT  user_id
        	      	, tileid
        	      	, finaoid
        	      	, NULL
        	      	, 122
        	      	, userid1
        	      	, UTC_TIMESTAMP( )
        	      	, userid1
        	      	, UTC_TIMESTAMP( )
        	      	, 1;

        		SELECT  MAX(trackingnotification_id) AS trackinid
	        	FROM    fn_trackingnotifications;
	        	
			SET return_value := 1;
		ELSE
			SIGNAL SQLSTATE '45001' SET 
      			MYSQL_ERRNO = 2008;
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