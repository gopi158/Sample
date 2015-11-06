DELIMITER //
CREATE PROCEDURE fngetTotalTiles_counts (IN user_id INT, IN actual_user_id INT )
BEGIN
IF actual_user_id != ''
THEN
SELECT user_tileid FROM `fn_user_finao_tile` ft JOIN fn_user_finao fu ON fu.`user_finao_id` = ft.`finao_id` WHERE ft.userid ='".$userid."' AND finao_activestatus !=2 and `finao_status_Ispublic` =1  GROUP BY tile_id;
ELSE
SELECT user_tileid FROM `fn_user_finao_tile` ft JOIN fn_user_finao fu ON fu.`user_finao_id` = ft.`finao_id` WHERE ft.userid ='".$userid."' AND finao_activestatus !=2 and Iscompleted =0 ;
END IF;
END //
DELIMITER ;

