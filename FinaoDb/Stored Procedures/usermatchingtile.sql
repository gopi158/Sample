DELIMITER //
DROP PROCEDURE IF EXISTS usermatchingtile //
	CREATE PROCEDURE usermatchingtile (IN t_id INT, IN u_id INT)
	BEGIN
			
	
		DECLARE total INT;
		DECLARE counter INT;
		DECLARE uniqueuserid INT;
		DECLARE totaltile INT;
		DECLARE totalfinao INT;
		DECLARE totalfollowing INT;
		DECLARE totalfollower INT;
		DECLARE totalinspired INT;
		
		CREATE TEMPORARY TABLE IF NOT EXISTS final 
		    		(
		      		 id SERIAL 
		    		, fname VARCHAR(100)
		    		, lname VARCHAR(100)
		    		, userid INT
		    		, mystory VARCHAR(500)
		    		, gptilname VARCHAR(250)
		    		, image VARCHAR(255)
		    		, tracker_id INT
		    		, tile_id INT
		    		, tracked_id INT
		    		, status BIT
		    		, finaomsg VARCHAR(500)
		    		, usertileid INT
		    		, totalfinaos INT
		    		, totalfollowings INT
		    		, totalfollowers INT
		    		, totaltiles INT
		    		, totalinspire INT
		    		);
		
		IF EXISTS (SELECT tile_id FROM fn_user_finao_tile WHERE tile_id = t_id)
				THEN
		
			INSERT INTO final
						(fname
		      			, lname
		      			, userid
		      			, mystory
		      			, gptilname
		      			, image
		      			, tracker_id
		      			, tile_id
		      			, tracked_id
		      			, status
		      			, finaomsg
		      			, usertileid)
		SELECT  usr.fname
		      			, usr.lname
		      			, usr.userid
		      			, profile.mystory
		  				, tile.tile_name
		      			, profile.profile_image AS image
		      			, track.tracker_userid
		      			, info.tile_id
		      			, track.tracked_userid
		      			, track.status
		      			, finao.finao_msg
		      			, tile.user_tileid
		FROM    fn_users usr
		        		JOIN fn_tracking track ON usr.userid = track.tracker_userid
		                          	        AND track.status = 1
		        		JOIN fn_user_finao finao ON usr.userid = finao.userid
		        		JOIN fn_user_finao_tile tile ON usr.userid = tile.userid
		                          	        AND finao.user_finao_id = tile.finao_id
						
		        		LEFT JOIN fn_tilesinfo info ON tile.tile_id = info.tile_id
		                                          AND tile.userid = info.createdby
		       		LEFT JOIN fn_user_profile profile ON usr.userid = profile.user_id
		       		INNER JOIN userfollowers follower ON tile.tile_id = follower.tileid
		WHERE   track.tracked_userid = u_id AND follower.tileid = t_id 
		        				AND finao.finao_activestatus != 2
		        				AND finao.finao_status_Ispublic = 1
		        				AND tile.status = 1
								
		GROUP BY usr.userid
		      			, usr.fname
		      			, usr.lname;
		
		   SELECT  COUNT(id)
			FROM    final INTO total;
		
			SET counter := 1;
		
		WHILE (counter <= total) DO 
		
			SELECT  userid
			FROM    final
			WHERE   id = COUNTER INTO uniqueuserid;
		
			SELECT  COUNT(DISTINCT tile_id)
			FROM    fn_trackingnotifications notification 
			INNER JOIN fn_users user ON user.userid = notification.tracker_userid
		                		AND notification.tracker_userid = uniqueuserid INTO totaltile;
		
			SELECT  COUNT(user_finao_id)
			FROM    fn_user_finao 
			WHERE   userid = uniqueuserid INTO totalfinao;
		
			SELECT COUNT(DISTINCT tracked_userid)
			FROM fn_tracking 
			WHERE tracker_userid = uniqueuserid INTO totalfollowing;
			
			SELECT COUNT(DISTINCT tracker_userid)
			FROM fn_tracking 
			WHERE tracked_userid = uniqueuserid INTO totalfollower;
			
			SELECT  COUNT(inspire.userpostid) AS totalinspire
			FROM    fn_uploaddetails upload
        					INNER JOIN inspiringpost inspire ON upload.uploaddetail_id = inspire.userpostid
			WHERE   inspire.inspireduserid = uniqueuserid INTO totalinspired;
			
			UPDATE  final
			SET     totaltiles = totaltile
		         	, totalfinaos = totalfinao
		         	, totalfollowings = totalfollowing
					, totalfollowers  = totalfollower
					, totalinspire = totalinspired
			WHERE   id = counter;
		
			SET counter := counter + 1;
		
		END WHILE;

	SELECT * FROM final;
	
			ELSE
						SIGNAL SQLSTATE '45001' 
						SET MYSQL_ERRNO = 2010; 
			END IF ;
	
		DROP TABLE IF EXISTS final;
	
	END //
	
DELIMITER //