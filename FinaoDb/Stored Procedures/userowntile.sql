DELIMITER //
DROP PROCEDURE IF EXISTS userowntile //
CREATE PROCEDURE `userowntile`(IN u_id INT)
BEGIN
			IF EXISTS (SELECT userid FROM fn_user_finao_tile WHERE userid = u_id)
				THEN
						SELECT DISTINCT
        						tile.tile_id
      							, info.tilename
      							, info.tile_imageurl
      							, info.status
						FROM    fn_user_finao_tile tile
        						INNER JOIN fn_tilesinfo info ON tile.tile_id = info.tile_id
						WHERE   tile.userid = u_id;
			ELSE
						SIGNAL SQLSTATE '45001' 
						SET MYSQL_ERRNO = 2001; 
			END IF ;
	END //
DELIMITER //