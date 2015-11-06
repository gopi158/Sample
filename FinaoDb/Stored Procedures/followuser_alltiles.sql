DELIMITER //
DROP PROCEDURE IF EXISTS followuser_alltiles //
CREATE  PROCEDURE `followuser_alltiles`(IN u_id INT, IN f_id INT)
BEGIN
	
	DECLARE return_value INT;
	DECLARE uniqid INT;
	DECLARE uniq_til_id INT;
	DECLARE counter INT;
	DECLARE total INT;
	SET autocommit = 0;
	SET return_value := 0;
	
			CREATE TEMPORARY TABLE IF NOT EXISTS tileids
    				(
      				ids SERIAL
    				, t_id INT
    				);
    				
			IF EXISTS (SELECT userid FROM fn_users WHERE userid = u_id )
			THEN
			 
			START TRANSACTION ;
			
			INSERT INTO tileids (t_id)		
				SELECT DISTINCT tile_id FROM fn_user_finao_tile WHERE userid = f_id ORDER BY tile_id;
			
			SELECT COUNT(ids) FROM tileids INTO total;
			
			SET counter :=1;
				
			WHILE (counter <= total)
			DO		
				SELECT t_id FROM tileids WHERE ids= counter INTO uniq_til_id;
			
			IF NOT EXISTS (SELECT userid FROM `userfollowers` WHERE userid = f_id AND followerid = u_id AND tileid = uniq_til_id )
			THEN
			
				INSERT INTO userfollowers
						( tileid
						, userid
        	        	, followerid
        	        	, isactive
        	        	, modification
        	        	, creation
						)
						SELECT  uniq_til_id
        	            , f_id
						, u_id
        	            , 1
        	            , UTC_TIMESTAMP( )
        	            , UTC_TIMESTAMP( );
        	            
        	    INSERT  INTO fn_tracking
        	        ( tracked_tileid
        	        , tracker_userid
        	        , tracked_userid
        	        , view_status
        	        , createddate
        	        , status
        	        , tracked_type
        	        )	 
        	        SELECT uniq_til_id
        	        		, f_id
        	        		, u_id
        	        		, 1
        	        		, UTC_TIMESTAMP( )
        	        		, 1
        	        		, 36;   
        	        		
        	    ELSE
        	    	UPDATE userfollowers
        	    	SET isactive = 1
        	    	WHERE userid = f_id AND followerid = u_id AND tileid = uniq_til_id ;
        	    	
        	    END IF;        	   
        	         		
        	    SET counter := counter + 1;
        	    END WHILE; 
        	            
				              
		SET return_value := 1;

		IF (u_id > 0 AND u_id != NULL)
			THEN
				START TRANSACTION ;
		INSERT  INTO fn_trackingnotifications
        		( tile_id
	        	, tracker_userid 
        		, journal_id
        		, notification_action
        		, updateby
        		, updateddate
        		, createdby
        		, createddate
        		, isread
        		)
        		SELECT  DISTINCT tile_id
        		      , finao_id
        		      , NULL
        		      , 80
        		      , u_id
        		      , UTC_TIMESTAMP( )
        		      , u_id
        		      , UTC_TIMESTAMP( )
        		      , 1
        		FROM fn_user_finao_tile WHERE userid = u_id ;
		
		SET return_value := 1;
		END IF;
        		SELECT  MAX(userfollowerid) AS userfollowerid
        		FROM    userfollowers;
		
		ELSE
				SIGNAL SQLSTATE '45001' 
				SET	MYSQL_ERRNO = 2009;
			END IF;	
			
		IF (return_value = 1)
		THEN
        	COMMIT;
        ELSE
	        ROLLBACK;
        END IF;
        
    DROP TEMPORARY TABLE IF EXISTS tileids;
    DROP TEMPORARY TABLE IF EXISTS followed_tile;
        
	END //
DELIMITER //
