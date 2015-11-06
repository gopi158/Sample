DELIMITER //
	DROP PROCEDURE IF EXISTS profile_follower //
	
	CREATE PROCEDURE profile_follower (IN id INT)

		BEGIN

			DECLARE totalinspired INT;			
			DECLARE totalfinaos INT;		
			DECLARE totaltiles INT;			
			DECLARE totalfollowings INT;			
			DECLARE totalfollowers INT;
			DECLARE uniqid INT;
			DECLARE counter INT;
			DECLARE total INT;			

			CREATE TEMPORARY TABLE IF NOT EXISTS output  
					(
						ids SERIAL
						, fname VARCHAR(128)
						, lname VARCHAR(128)
						, userid INT
						, mystory VARCHAR(500)
						, name VARCHAR(255)
        				, profile_img VARCHAR(500)
        				, tracker_id INT
        				, tileid INT
        				, trackerid INT
        				, trackedid INT
        				, status BIT
        				, finaomsg VARCHAR(500)
						, totalfinao INT
						, totaltile INT
						, following INT
						, follower INT
						, inspired INT
    					);


				IF EXISTS (SELECT userid FROM fn_user_finao_tile WHERE userid = id)
				THEN
					INSERT INTO output 
						(
						 fname 
						, lname
						, userid 
						, mystory 
						, name 
        				, profile_img 
        				, tracker_id 
        				, tileid 
        				, trackerid 
        				, trackedid 
        				, status 
        				, finaomsg 
						, totalfinao 
						, totaltile 
						, following 
						, follower 
						, inspired 
						)
					SELECT  usr.fname
      						, usr.lname
      						, usr.userid
      						, profile.mystory
      						, tile.tile_name 
      						, profile.profile_image AS image
      						, track.tracker_userid
      						, tile.tile_id
      						, track.tracker_userid
      						, track.tracked_userid
      						, track.status
      						, finao.finao_msg
      						, 0
      						, 0
      						, 0
      						, 0
      						, 0
					FROM    fn_users usr
        					JOIN fn_tracking track ON usr.userid = track.tracker_userid
                                  			AND track.status = 1
        					JOIN fn_user_finao finao ON usr.userid = finao.userid
        					JOIN fn_user_finao_tile tile ON usr.userid = tile.userid
                                      		AND finao.user_finao_id = tile.finao_id
        					LEFT JOIN fn_tilesinfo info ON tile.tile_id = info.tile_id
                                      		AND tile.userid = info.createdby
        					LEFT JOIN fn_user_profile profile ON usr.userid = profile.user_id
					WHERE   track.tracked_userid = id
        						AND finao.finao_activestatus != 2
        						AND finao.finao_status_Ispublic = 1
        						AND tile.status = 1
					GROUP BY usr.userid
      						, usr.fname
      						, usr.lname;

					SELECT COUNT(ids) FROM output INTO total;

					SET counter := 1;

					WHILE ( counter <= total )
						DO
						
						SELECT userid FROM output WHERE ids = counter INTO uniqid ;

						SELECT  COUNT(inspire.userpostid) AS totalinspire
						FROM    fn_uploaddetails upload
        							INNER JOIN inspiringpost inspire ON upload.uploaddetail_id = inspire.userpostid
						WHERE   inspire.inspireduserid = uniqid INTO totalinspired;

						SELECT  COUNT(finao_id) AS finao_id
						FROM    fn_user_finao_tile
						WHERE   userid = uniqid INTO totalfinaos;

						SELECT  COUNT(tile_id) AS tile_id
						FROM    fn_user_finao_tile
						WHERE   userid = uniqid INTO totaltiles;

						SELECT COUNT(tracked_userid)
						FROM fn_tracking 
						WHERE tracker_userid = uniqid INTO totalfollowings;

						SELECT COUNT(tracker.tracker_userid)
						FROM fn_tracking tracker
						INNER JOIN fn_trackingnotifications notification ON tracker.tracker_userid = notification.tracker_userid
						WHERE tracker.tracked_userid = uniqid INTO totalfollowers;

						UPDATE output
						SET  totalfinao = totalfinaos
							, totaltile = totaltiles
							, following = totalfollowings
							, follower = totalfollowers
							, inspired = totalinspired
						WHERE userid = uniqid;

						SET counter:= counter + 1;
					END WHILE;

				SELECT  fname 
						, lname 
						, userid 
						, mystory
						, name
        				, profile_img 
        				, tracker_id 
        				, tileid 
        				, trackerid 
        				, trackedid 
        				, status 
        				, finaomsg 
						, totalfinao 
						, totaltile 
						, following 
						, follower
						, inspired 
				FROM output;

			ELSE
				SIGNAL SQLSTATE '45001' 
				SET MYSQL_ERRNO = 2001; 	
			END IF;

			DROP TABLE IF EXISTS output;

		END //

DELIMITER //