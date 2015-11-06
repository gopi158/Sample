DELIMITER //
CREATE PROCEDURE tilescount (IN userid INT)
BEGIN
SELECT user_tileid FROM `fn_user_finao_tile` ft JOIN fn_user_finao fu ON fu.`user_finao_id` = ft.`finao_id` WHERE ft.userid =userid AND Iscompleted =0 AND finao_activestatus !=2 AND finao_status_Ispublic =1 GROUP BY tile_id;
END //
DELIMITER //
