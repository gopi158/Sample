DELIMITER //
CREATE PROCEDURE updatefinao (IN finao_id INT, IN user_id INT, IN srctile_id INT, IN targettile_id INT)
BEGIN
update fn_user_finao_tile set tile_id=targettile_id where tile_id=srctile_id and userid=user_id and finao_id=finao_id;
END //
DELIMITER //
