DELIMITER //
CREATE PROCEDURE getuser_finaocounts (IN user_id INT)
BEGIN
SELECT user_tileid FROM `fn_user_finao_tile` ft JOIN fn_user_finao fu ON fu.`user_finao_id` = ft.`finao_id` WHERE ft.userid =userid AND Iscompleted =0 AND finao_activestatus !=2  GROUP BY tile_id;
END //
DELIMITER //
