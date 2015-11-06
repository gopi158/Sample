DELIMITER //
DROP PROCEDURE IF EXISTS public_finao //
CREATE PROCEDURE `public_finao`(IN u_id INT, IN t_id INT)
BEGIN
	IF EXISTS (SELECT user_tileid FROM fn_user_finao_tile WHERE userid = u_id AND tile_id = t_id)
	THEN		
				SELECT  tile.tile_id
      			, tile.tilename
      			, ftile.userid
      			, ftile.finao_id
      			, tile.tile_imageurl
      			, upload.uploadfile_name
      			, upload.uploadfile_path
      			, upload.uploadtype
      			, upload.upload_sourcetype
      			, finao.finao_msg
      			, lookup.code
				, finao.finao_status_ispublic
				, finao.createddate
		FROM    fn_tilesinfo tile
				INNER JOIN fn_user_finao_tile ftile ON ftile.tile_id = tile.tile_id
				LEFT OUTER JOIN fn_uploaddetails upload ON ftile.finao_id = upload.upload_sourceid
				INNER JOIN fn_user_finao finao ON finao.user_finao_id = ftile.finao_id
				INNER JOIN fn_lookups lookup ON lookup.lookup_id = finao.finao_status
		WHERE   ftile.userid = u_id
        		AND tile.tile_id = t_id
				AND finao.finao_activestatus = 1
				AND tile.status= 1
				AND finao.finao_status_Ispublic = 1
				GROUP BY (upload_sourceid) ;
        		
	ELSE
			SIGNAL SQLSTATE '45001' 
			SET MYSQL_ERRNO = 2010; 
	END IF;
        		
END //
DELIMITER //