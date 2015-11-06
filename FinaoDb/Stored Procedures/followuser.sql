DELIMITER //
DROP PROCEDURE IF EXISTS followuser //
CREATE PROCEDURE `followuser`(
      IN u_id INT
    , IN f_id INT
    , IN t_id INT
    )
BEGIN
	
	DECLARE return_value INT;
	SET autocommit = 0;
	SET return_value := 0;

	IF NOT EXISTS (SELECT userfollowerid FROM userfollowers WHERE tileid = t_id AND userid = f_id AND followerid = u_id AND isactive = 1 )
		THEN
		IF NOT EXISTS (SELECT userfollowerid FROM userfollowers WHERE tileid = t_id AND userid = f_id AND followerid = u_id )
		THEN
		START TRANSACTION ;
	        INSERT  INTO userfollowers
        	        ( userid
        	        , followerid
        	        , tileid
        	        , isactive
        	        , modification
        	        , creation
        	        )
        	        SELECT  f_id
        	              , u_id 
        	              , t_id
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
        	        SELECT f_id
        	        		, u_id  
        	        		, t_id
        	        		, 1
        	        		, UTC_TIMESTAMP( )
        	        		, 1
        	        		, 36;             	              

		INSERT  INTO fn_trackingnotifications
        		( tracker_userid
	        	, tile_id
        		, journal_id
        		, notification_action
        		, updateby
        		, updateddate
        		, createdby
        		, createddate
        		, isread
        		)
        		SELECT  u_id
        		      , t_id
        		      , NULL
        		      , 79
        		      , f_id
        		      , UTC_TIMESTAMP( )
        		      , f_id
        		      , UTC_TIMESTAMP( )
        		      , 1;
		SET return_value := 1;
		

        		SELECT  MAX(userfollowerid) AS userfollowerid
        		FROM    userfollowers;
		ELSE
			SET SQL_SAFE_UPADTES = 0;
			UPDATE userfollowers
        	SET isactive = 1
        	WHERE tileid = t_id AND userid = f_id AND followerid = u_id AND isactive = 0;
        	SET return_value := 1;

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
