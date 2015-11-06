DELIMITER //
DROP PROCEDURE IF EXISTS unusedtile //
CREATE PROCEDURE unusedtile (IN id INT)
BEGIN
	IF EXISTS (SELECT userid FROM fn_user_finao_tile WHERE userid = id)
		THEN
        	SELECT  tile_id
              	, tilename
              	, tile_imageurl
        	FROM    fn_tilesinfo
        	WHERE   tile_id NOT IN ( SELECT  DISTINCT
                  	                      tile_id
                     	            FROM   fn_user_finao_tile
                        	         WHERE  userid = id );
        ELSE
        		SIGNAL SQLSTATE '45000'
        		SET MYSQL_ERRNO = 2001; 
        END IF;                	         
	END //
	DELIMITER //