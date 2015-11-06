DELIMITER //
CREATE PROCEDURE userlogontilescount (IN userid INT )
BEGIN
SELECT user_tileid FROM `fn_user_finao_tile` ft JOIN fn_user_finao fu ON fu.`user_finao_id` = ft.`finao_id` WHERE ft.userid =userid AND Iscompleted =0 AND STATUS =1 AND finao_activestatus =1 GROUP BY tile_id;
END //
DELIMITER //
