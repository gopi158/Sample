DELIMITER //
DROP PROCEDURE IF EXISTS mytiles //
CREATE PROCEDURE `mytiles`(IN u_name VARCHAR(256))
BEGIN
	DECLARE total INT;
	DECLARE tilecounter INT;
	DECLARE uniqtileid INT;
	DECLARE totalfinao INT;
	DECLARE finaocounter INT;
	DECLARE uniqfinao INT;
	DECLARE uniqfinaoid INT;
	DECLARE uuid INT;
	
		IF u_name > 0 
		THEN
			SET uuid := u_name;
		ELSE
			SELECT userid FROM fn_users WHERE uname = u_name INTO uuid;	
		END IF;
	
	CREATE TEMPORARY TABLE IF NOT EXISTS output ( tid SERIAL, ttid INT, name VARCHAR(100), status INT,  imageurl varchar(250), uploadimg VARCHAR(250), uploadpath VARCHAR(250), type BIT);
			INSERT INTO output (ttid, name, status, imageurl, uploadpath, type)				
					SELECT DISTINCT
        					tile.tile_id
      						,  tile.tilename
      						, tile.status
							, tile.tile_imageurl
							, NULL
							, 0
					FROM    fn_tilesinfo tile
        					WHERE tile.status = 1;

	CREATE TEMPORARY TABLE IF NOT EXISTS final(id SERIAL,  tileid INT, tilename VARCHAR(100), tileimage VARCHAR (255));
		INSERT INTO final(tileid, tilename)
				SELECT  fn_tilesinfo.tile_id , fn_tilesinfo.tilename 
						FROM fn_user_finao_tile 
						INNER JOIN fn_tilesinfo ON 
						fn_user_finao_tile.tile_id= fn_tilesinfo.tile_id 
						WHERE fn_user_finao_tile.STATUS = 1 
						And fn_user_finao_tile.userid = uuid
						AND fn_tilesinfo.STATUS = 1 ;
				
				SET tilecounter := 1;

				SELECT COUNT(id) FROM final INTO total;

					WHILE tilecounter <= total
					DO

						SELECT tileid FROM final WHERE id = tilecounter INTO uniqtileid;

						CREATE TEMPORARY TABLE IF NOT EXISTS finao  (ids SERIAL,  finaoid INT);
							INSERT INTO finao (finaoid)
								SELECT DISTINCT finao_id FROM fn_user_finao_tile WHERE userid = uuid AND tile_id = uniqtileid;
								
								SET finaocounter := 1;
								SELECT COUNT(ids) FROM finao INTO totalfinao;
									WHILE finaocounter <= totalfinao
									DO
										SELECT finaoid FROM finao WHERE ids = finaocounter INTO uniqfinao;
										
										
							
											SET SQL_SAFE_UPDATES = 0;
											UPDATE output
											SET uploadimg  = (SELECT uploadfile_name FROM fn_uploaddetails WHERE upload_sourceid = uniqfinao order by updateddate desc limit 1 ),
											uploadpath  = (SELECT uploadfile_path FROM fn_uploaddetails WHERE upload_sourceid = uniqfinao order by updateddate desc limit 1)
											, type = 1
											WHERE ttid = uniqtileid;
									
									SET finaocounter := finaocounter + 1;
									END WHILE;

					SET tilecounter := tilecounter + 1;
					END WHILE;
	
				SELECT DISTINCT
					ttid
				  , name
				  , status
				  , imageurl
					, uploadimg
				  , uploadpath
				  , type
			FROM    output
			ORDER BY type DESC;

	drop table if exists output;
	DROP TABLE IF EXISTS final;
	drop table if exists finao;
END //
DELIMITER //