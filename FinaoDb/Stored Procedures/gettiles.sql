DELIMITER //
DROP PROCEDURE IF EXISTS gettiles //
CREATE PROCEDURE gettiles ()
BEGIN
	SELECT tile.tile_id
      		, tile.tilename
      		, tile.tile_imageurl
      		, tile.status
	FROM    fn_lookups lookup
        		INNER JOIN fn_tilesinfo tile ON lookup.lookup_id = tile.tile_id
	WHERE tile.status=1 AND lookup.lookup_status = 1;
END //
DELIMITER //