DELIMITER //
CREATE PROCEDURE insertfinaotile (IN tile_id INT,IN tile_name VARCHAR(100),IN finao_id INT,IN tile_image VARCHAR(100),IN userid INT)
BEGIN
insert into fn_user_finao_tile(tile_id,tile_name,userid,finao_id,tile_profileImagurl,status,createddate,createdby,updateddate,updatedby)values(tile_id,tile_name,userid,finao_id,tile_image,1,NOW(),userid,NOW(),userid);
END //
DELIMITER //
