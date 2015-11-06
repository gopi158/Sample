DELIMITER //
DROP PROCEDURE IF EXISTS getuserstile //
CREATE PROCEDURE `getuserstile`(IN id INT, IN iscompletestatus INT, IN ispublic INT)
BEGIN

	CREATE TEMPORARY TABLE IF NOT EXISTS trackedid 
   	(
     	id INT
    	);

	IF (iscompletestatus = NULL)
	THEN
	SET iscompletestatus = 10;
	END IF;
	
	IF (iscompletestatus = 0)
	THEN
	SET ispublic = 10;
	END IF;

	IF EXISTS (SELECT user_tileid FROM fn_user_finao_tile WHERE userid = id)
	THEN
		IF (iscompletestatus = 0)
		THEN	
        		SELECT  tile.tile_id
              			, tile.tile_name
              			, tile.tile_profileImagurl
              			, finao.finao_msg
				, finao.user_finao_id
				, tile.createddate
				, tile.createdby
				, tile.updateddate
				, tile.updatedby
				, tile .explore_finao
				, tile.status
				, tile.user_tileid
        		FROM    fn_user_finao_tile tile
                			INNER JOIN fn_user_finao finao ON tile.finao_id = finao.user_finao_id
        		WHERE   tile.userid = id 
		ORDER BY tile.tile_id;	 
		ELSE
		IF (ispublic = 1)
			THEN
			INSERT  INTO trackedid
                    		SELECT  tracked_userid
                    		FROM    fn_tracking
                    		WHERE   tracker_userid = id;

			SELECT  tile.tile_id
              			, tile.tile_name
              			, tile.tile_profileImagurl
              			, finao.finao_msg
				, finao.user_finao_id
				, tile.createddate
				, tile.createdby
				, tile.updateddate
				, tile.updatedby
				, tile .explore_finao
				, tile.status
				, tile.user_tileid
        		FROM    fn_user_finao_tile tile
                			INNER JOIN fn_user_finao finao ON tile.finao_id = finao.user_finao_id
        				INNER JOIN trackedid track ON track.id = tile.userid				ORDER BY tile.tile_id;
		END IF;
    	END IF;

	ELSE
		SIGNAL SQLSTATE '45001' 
		SET MYSQL_ERRNO = 2001;
 	END IF;
		DROP TABLE IF EXISTS trackedid;
END //
DELIMITER //
