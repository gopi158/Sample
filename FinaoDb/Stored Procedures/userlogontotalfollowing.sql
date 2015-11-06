DELIMITER //
CREATE PROCEDURE userlogontotalfollowing (IN userid INT )
BEGIN
select t.userid from fn_users t join fn_tracking t1 on t.userid = t1.tracked_userid and t1.status = 1  join fn_user_finao t2 on t.userid = t2.userid join fn_user_finao_tile t3 on t.userid = t3.userid and t2.user_finao_id = t3.finao_id left join fn_tilesinfo t4 on t3.tile_id = t4.tile_id and t3.userid = t4.createdby  left join fn_user_profile t5 on t.userid = t5.user_id where t1.tracker_userid = userid and t2.finao_activestatus != 2 and t2.finao_status_Ispublic = 1 and t3.status = 1 group by t.userid,t.fname,t.lname;
END //
DELIMITER //
