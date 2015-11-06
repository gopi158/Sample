DELIMITER //
DROP PROCEDURE IF EXISTS finao_list //
CREATE PROCEDURE `finao_list`(IN u_name VARCHAR(256), IN type INT)
BEGIN 

	DECLARE u_id INT;
	
	 	IF u_name > 0 
		THEN
			SET u_id := u_name;
		ELSE
			SELECT userid FROM fn_users WHERE uname = u_name INTO u_id;	
		END IF;
		
	IF EXISTS (SELECT user_finao_id FROM fn_user_finao WHERE userid = u_id)
		THEN
			
			IF ( type = 0 ) 
			THEN
				SELECT  ftile.finao_id
					  , finao.finao_msg
					  , tile.tile_id
					  , lookup.code
					  , finao.finao_status_Ispublic
				FROM    fn_user_finao finao
						INNER JOIN fn_user_finao_tile ftile ON finao.user_finao_id = ftile.finao_id
						INNER JOIN fn_lookups lookup ON lookup.lookup_id = finao.finao_status
						AND lookup.lookup_status
						INNER JOIN fn_tilesinfo tile ON tile.tile_id = ftile.tile_id
				WHERE   finao.finao_activestatus = 1
						AND tile.status = 1
						AND finao.userid = u_id
						AND finao.Iscompleted = 0
				ORDER BY finao.updateddate DESC;

			ELSE 
				SELECT  ftile.finao_id
					  , finao.finao_msg
					  , tile.tile_id
					  , lookup.code
					  , finao.finao_status_Ispublic
				FROM    fn_user_finao finao
						INNER JOIN fn_user_finao_tile ftile ON finao.user_finao_id = ftile.finao_id
						INNER JOIN fn_lookups lookup ON lookup.lookup_id = finao.finao_status
						AND lookup.lookup_status
						INNER JOIN fn_tilesinfo tile ON tile.tile_id = ftile.tile_id
				WHERE   finao.finao_activestatus = 1
						AND tile.status = 1
						AND finao.userid = u_id
						AND finao.finao_status_Ispublic = 1
				ORDER BY finao.updateddate DESC;

			END IF; 
		ELSE
				SIGNAL SQLSTATE '45001' 
				SET MYSQL_ERRNO = 2001; 
		END IF; 
	   
END //
DELIMITER //