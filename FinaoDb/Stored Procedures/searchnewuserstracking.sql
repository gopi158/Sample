DELIMITER //
CREATE PROCEDURE searchnewuserstracking( IN userid INT ) BEGIN SELECT t.userid
FROM fn_users t
JOIN fn_tracking t1 ON t.userid = t1.tracker_userid
AND t1.status =1
JOIN fn_user_finao t2 ON t.userid = t2.userid
JOIN fn_user_finao_tile t3 ON t.userid = t3.userid
AND t2.user_finao_id = t3.finao_id
LEFT JOIN fn_tilesinfo t4 ON t3.tile_id = t4.tile_id
AND t3.userid = t4.createdby
LEFT JOIN fn_user_profile t5 ON t.userid = t5.user_id
WHERE t1.tracked_userid = userid
AND t2.finao_activestatus !=2
AND t2.finao_status_Ispublic =1
AND t3.status =1
GROUP BY t.userid, t.fname, t.lname;
END //
DELIMITER //
