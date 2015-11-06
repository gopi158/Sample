DELIMITER //
CREATE PROCEDURE getfinaores (IN finao_id INT)
BEGIN
select tile_id,tile_name from fn_user_finao_tile where finao_id= finao_id;
END //
DELIMITER //
