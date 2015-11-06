DELIMITER //
CREATE PROCEDURE updateexplorefinao (IN tile_id INT)
BEGIN
UPDATE fn_user_finao_tile SET explore_finao=1 WHERE tile_id=tile_id;
END //
DELIMITER //
