DELIMITER //
DROP PROCEDURE IF EXISTS usertiles //
CREATE PROCEDURE usertiles (IN id INT)
BEGIN
SELECT follower.tileid, tile.tilename, tile.tile_imageurl FROM userfollowers follower INNER JOIN fn_tilesinfo tile ON follower.tileid = tile.tile_id WHERE follower.followerid = id;
END //
DELIMITER //
