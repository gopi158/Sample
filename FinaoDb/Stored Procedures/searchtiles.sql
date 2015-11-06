DELIMITER //
CREATE PROCEDURE searchtiles (IN search VARCHAR(100))
BEGIN
SELECT t.tile_id, t.userid, fo.tilename, t.`finao_id` , t1.finao_activestatus, fo.status, t1.finao_msg, t.tile_profileImagurl, t1. * FROM fn_user_finao_tile t JOIN fn_user_finao t1 ON t.finao_id = t1.user_finao_id JOIN fn_tilesinfo fo ON fo.tile_id = t.tile_id AND t1.finao_status_Ispublic =1 AND t.status =1 AND t1.finao_activestatus !=2 AND fo.tilename LIKE search GROUP BY fo.tilename, t.userid;
END //
DELIMITER //
