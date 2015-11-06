DELIMITER //
DROP procedure IF EXISTS `userpublic_detail` //
CREATE PROCEDURE `userpublic_detail`(IN id INT)
BEGIN
			DECLARE totalinspired INT;			
			DECLARE totalfinaos INT;		
			DECLARE totaltiles INT;			
			DECLARE totalfollowings INT;			
			DECLARE totalfollowers INT;			

			CREATE TEMPORARY TABLE IF NOT EXISTS output  
					(
						 profile_img VARCHAR(255)
        				, banner_img VARCHAR(500)
        				, name VARCHAR(128)
        				, mystory VARCHAR(500)
						, totalfinao INT
						, totaltile INT
						, following INT
						, follower INT
						, inspired INT

    					);

				IF EXISTS (SELECT userid FROM fn_users WHERE userid = id)
				THEN

					SELECT  COUNT(inspire.userpostid) AS totalinspire
					FROM    fn_uploaddetails upload
        							INNER JOIN inspiringpost inspire ON upload.uploaddetail_id = inspire.userpostid
					WHERE   inspire.inspireduserid = id INTO totalinspired;

					SELECT  COUNT(DISTINCT finao_id) AS finao_id
					FROM    fn_user_finao_tile
					WHERE   userid = id INTO totalfinaos;

					SELECT  COUNT(DISTINCT tile_id) AS tile_id
					FROM    fn_user_finao_tile
					WHERE   userid = id INTO totaltiles;

					SELECT COUNT(DISTINCT tracked_userid)
					FROM fn_tracking 
					WHERE tracker_userid = id INTO totalfollowings;

					SELECT COUNT(DISTINCT tracker.tracker_userid)
					FROM fn_tracking tracker
					INNER JOIN fn_trackingnotifications notification ON tracker.tracker_userid = notification.tracker_userid
					WHERE tracker.tracked_userid = id INTO totalfollowers;


				
				INSERT  INTO output
        						(
						profile_img
        				, banner_img
        				, name
        				, mystory
						, totalfinao
						, totaltile
						, following
						, follower
						, inspired
       						 )		
        						SELECT  profile.profile_image
              				, profile.profile_bg_image
              				, CONCAT_WS(  ' ', usr.fname, usr.lname ) AS name
              				, profile.mystory
							, totalfinaos
							, totaltiles
							, totalfollowings
							, totalfollowers
							, totalinspired
        						FROM    fn_user_profile profile
                						INNER JOIN fn_users usr ON usr.userid = profile.user_id
        						WHERE   usr.userid = id;

				SELECT * FROM output;
			
			ELSE
				SIGNAL SQLSTATE '45001' 
				SET MYSQL_ERRNO = 2001; 	
			END IF;

			DROP TABLE IF EXISTS output;
   
			END //

DELIMITER //

