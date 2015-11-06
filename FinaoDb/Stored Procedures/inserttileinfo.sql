DELIMITER //
CREATE PROCEDURE inserttileinfo (IN tile_id INT,IN tile_name VARCHAR(50),IN userid INT, IN tile_image VARCHAR(100))
BEGIN
insert into fn_tilesinfo(tile_id,tilename,tile_imageurl,status,createddate,createdby,updateddate,updatedby)values
(tile_id, tile_name, tile_image,'1',NOW(),userid,NOW(),userid);
END //
DELIMITER //
