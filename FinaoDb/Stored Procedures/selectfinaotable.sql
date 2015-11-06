DELIMITER //
CREATE PROCEDURE selectfinaotable (IN tile_id INT,IN tile_name VARCHAR(50),IN userid INT)
BEGIN
select tilesinfo_id from fn_tilesinfo where tile_id= tile_id and createdby= userid and tilename like '%tile_name%';
END //
DELIMITER //
