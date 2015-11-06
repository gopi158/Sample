DELIMITER //
CREATE PROCEDURE getfinao (IN id INT)
BEGIN
select tile_id,tile_name from fn_user_finao_tile where finao_id= id;
END //
DELIMITER //
