DELIMITER //
DROP PROCEDURE IF EXISTS followers //
CREATE PROCEDURE `followers`(IN u_name VARCHAR(256))
BEGIN
		
		DECLARE total INT;
		DECLARE counter INT;
		DECLARE uniqueuserid INT;
		DECLARE tilecount INT;
		DECLARE tilecounter INT;
		DECLARE uniqtileid INT;
		DECLARE uniqtilename VARCHAR (255);
		DECLARE uniqtileimage VARCHAR (500);
		DECLARE alltiles VARCHAR (1000);
		DECLARE alltileimages VARCHAR(4000);
		DECLARE alltilenames VARCHAR (2000);
		DECLARE ids INT;
		
		CREATE TEMPORARY TABLE IF NOT EXISTS final 
		    		(
		      		 id SERIAL 
		    		, fname VARCHAR(100)
		    		, lname VARCHAR(100)
		    		, userid INT
		    		, username VARCHAR(256)
		    		, mystory VARCHAR(500)
		    		, gptilname VARCHAR(250)
		    		, image VARCHAR(255)
		    		, tracker_id INT
		    		, tile_id INT
		    		, tracked_id INT
		    		, status INT
		    		, finaomsg VARCHAR(500)
		    		, usertileid INT
		    		, tiles VARCHAR (1000)
					, tilenames VARCHAR (2000)
					, tilesimage VARCHAR (4000)
		    		);
		
		CREATE TEMPORARY TABLE IF NOT EXISTS tileinfo(t_id SERIAL, t_tileid INT, tileimage VARCHAR(255), tilename VARCHAR(255));		
		
		IF u_name > 0 
		THEN
			SET ids := u_name;
		ELSE
			SELECT userid FROM fn_users WHERE uname = u_name INTO ids;	
		END IF;
		
		IF EXISTS (SELECT tracking_id FROM fn_tracking WHERE tracked_userid = ids)
		THEN
		INSERT INTO final
		( userid
				, fname
				, lname
		      	, username
		      	, mystory	
		      	, image
				, tile_id
				, gptilname
		      	, tracker_id
		      	, tracked_id
		      	, status
		      	, finaomsg
		      	, usertileid)
			SELECT  DISTINCT
					follow.followerid
				  , usr.fname
				  , usr.lname
				  , usr.uname
				  , profile.mystory
				  , profile.profile_image AS image
				  , tile.tile_id
				  , tile.tilename
				  , track.tracker_userid
				  , track.tracked_userid
				  , track.status
				  , finao.finao_msg
				  , ftile.user_tileid
			FROM    userfollowers follow
					INNER JOIN fn_users usr ON follow.followerid = usr.userid
					INNER JOIN fn_user_profile profile ON profile.user_id = follow.followerid
					INNER JOIN fn_user_finao_tile ftile ON ftile.userid = follow.followerid
					INNER JOIN fn_tilesinfo tile ON tile.tile_id = ftile.tile_id
													AND tile.status = 1
													AND ftile.status = 1
					INNER JOIN fn_user_finao finao ON finao.user_finao_id = ftile.finao_id
													  AND finao.finao_activestatus = 1
					INNER JOIN fn_tracking track ON follow.followerid = track.tracked_userid
													AND track.status = 1
			WHERE   follow.userid = ids
					AND follow.isactive = 1
			GROUP BY follow.followerid;  
		
		   SELECT  COUNT(id)
			FROM    final INTO total;
		
			SET counter := 1;
		
		WHILE (counter <= total) DO 
		
			SELECT  userid
			FROM    final
			WHERE   id = COUNTER INTO uniqueuserid;
		

			INSERT INTO tileinfo(t_tileid, tileimage, tilename)
			SELECT DISTINCT user.tileid, info.tile_imageurl, info.tilename from userfollowers user 
			INNER JOIN fn_tilesinfo info ON info.tile_id = user.tileid 
			WHERE user.userid = ids AND info.status = 1 AND user.isactive = 1;
			
			SELECT COUNT(t_id) FROM tileinfo INTO tilecount;
			
			SET tilecounter := 1;
			SET alltiles := '';
			SET alltileimages := '';
			SET alltilenames := '';
			
			WHILE tilecounter <= tilecount DO
				SELECT t_tileid FROM tileinfo where t_id = tilecounter INTO uniqtileid;
				SELECT tilename FROM tileinfo where t_id = tilecounter INTO uniqtilename;
				SELECT tileimage FROM tileinfo where t_id = tilecounter INTO uniqtileimage;
				IF(tilecounter = 1) THEN
				    SET alltiles := uniqtileid;
				    SET alltileimages := uniqtileimage;
					SET alltilenames := uniqtilename;
				ELSE
					SET alltiles := CONCAT(alltiles, '|', uniqtileid);
					SET alltilenames := CONCAT(alltilenames, '|', uniqtilename);
					SET alltileimages := CONCAT(alltileimages, '|', uniqtileimage);
				END IF;
				SET tilecounter := tilecounter + 1;
			END WHILE;
			
			TRUNCATE TABLE tileinfo;
			
			UPDATE  final
			SET   tiles = alltiles
				, tilenames = alltilenames
				, tilesimage = alltileimages
			WHERE   id = counter;
		
			SET counter := counter + 1;
		
		END WHILE;

	SELECT * FROM final ORDER BY fname;
	ELSE
		SIGNAL SQLSTATE '45001' 
		SET MYSQL_ERRNO = 2001; 
	END IF;
		
		DROP TABLE IF EXISTS final ;
		DROP TABLE IF EXISTS tileinfo;

END //
DELIMITER //