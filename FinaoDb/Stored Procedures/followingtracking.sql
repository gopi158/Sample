DELIMITER //
CREATE PROCEDURE followingtracking (IN tracker_userid INT)
BEGIN
SELECT t.*, t1.tile_name FROM `fn_tracking` `t`  join fn_user_finao_tile t1 on t.tracked_tileid = t1.tile_id and t.tracker_userid = t1.userid  join fn_user_finao t2 on t1.finao_id = t2.user_finao_id  and finao_activestatus != 2 and finao_status_Ispublic = 1 WHERE  t.tracked_userid = tracker_userid and t.status = 0 GROUP BY  t1.tile_id, t1.tile_name;
END //
DELIMITER //
