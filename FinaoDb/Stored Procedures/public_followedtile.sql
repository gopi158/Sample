DELIMITER //
DROP PROCEDURE IF EXISTS public_followedtile //
CREATE PROCEDURE `public_followedtile`(IN u_name VARCHAR(256), IN f_name VARCHAR(256))
BEGIN

	DECLARE total INT;
	DECLARE counter INT;
	DECLARE tilecounter INT;
	DECLARE u_id INT;
	DECLARE f_id INT;
	
	 	IF u_name > 0 
		THEN
			SET u_id := u_name;
		ELSE
			SELECT userid FROM fn_users WHERE uname = u_name INTO u_id;	
		END IF;
		
		IF f_name > 0 
		THEN
			SET f_id := f_name;
		ELSE
			SELECT userid FROM fn_users WHERE uname = f_name INTO f_id;	
		END IF;
		
CREATE TEMPORARY TABLE IF NOT EXISTS final (id SERIAL,  tileid INT, tilename VARCHAR(100), tileimage VARCHAR (255), status INT, type INT);

			IF EXISTS (SELECT userid FROM fn_user_finao_tile WHERE userid = f_id)
				THEN
					INSERT INTO final (tileid, tilename, tileimage, status, type)
							SELECT DISTINCT
        						info.tile_id
      							, info.tilename
      							, info.tile_imageurl
      							, info.status
      							, 0
						FROM    fn_user_finao_tile tile
        						INNER JOIN fn_tilesinfo info ON tile.tile_id = info.tile_id
						WHERE   tile.userid = f_id AND info.status = 1 AND tile.status = 1;  
						
				SELECT COUNT(id) FROM final INTO total;
				
				SET counter := 1;
				
				WHILE (counter <= total )
				DO
					SELECT tileid FROM final WHERE id = counter INTO tilecounter;
					
					IF EXISTS (SELECT tileid FROM userfollowers WHERE userid = f_id AND tileid = tilecounter AND followerid = u_id AND isactive = 1)
					THEN
					
					SET SQL_SAFE_UPDATES = 0;					
					UPDATE final
					SET type = 1
					WHERE id = counter; 
					
					END IF;
					
					SET counter := counter + 1;
				END WHILE;	
				SELECT * FROM final;
			ELSE
						SIGNAL SQLSTATE '45001' 
						SET MYSQL_ERRNO = 2001; 
			END IF ;
			DROP TABLE IF EXISTS final;
	END //
	DELIMITER //