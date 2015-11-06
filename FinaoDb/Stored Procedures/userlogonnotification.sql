DELIMITER //
CREATE PROCEDURE userlogonnotification (IN userid INT )
BEGIN
SELECT count(*) as totalnotifications FROM `fn_tracking` `t` JOIN fn_user_finao_tile t1 ON t.tracked_tileid = t1.tile_id AND t.tracker_userid = t1.userid JOIN fn_user_finao t2 ON t1.finao_id = t2.user_finao_id LEFT JOIN fn_tilesinfo fo ON fo.tile_id = t1.user_tileid AND finao_activestatus !=2 AND finao_status_Ispublic =1 WHERE t.tracked_userid =userid AND t.status =0 GROUP BY t1.tile_id, fo.tilename;
END //
DELIMITER //
