DELIMITER //
CREATE PROCEDURE sendinvites ()
BEGIN
SELECT t.*, t1 . *, t6.profile_image,t6.mystory, t4.lookup_name as finaostatus, t1.updateddate as finaoupdateddate,DATE_FORMAT(t1.updateddate,'%d %b %y') as fupdateddate, t2.fname, t2.lname, t3.lookup_name, t5.tile_id,t5.tile_name FROM `fn_trackingnotifications` `t` Join fn_user_finao t1 ON t.finao_id = t1.user_finao_id JOIN fn_users t2 JOIN fn_user_profile t6 ON t.updateby = t2.userid JOIN fn_lookups t3 ON t.notification_action = t3.lookup_id AND t3.lookup_type = 'notificationaction' JOIN fn_lookups t4 ON t1.finao_status = t4.lookup_id AND t4.lookup_type = 'finaostatus' JOIN fn_user_finao_tile t5 ON t1.user_finao_id = t5.finao_id WHERE t.tracker_userid = ".$userid." AND t6.`user_id` = t2.userid
 and t1.finao_status_Ispublic = 1 and t1.finao_activestatus = 1 GROUP BY t.tile_id, t.finao_id ,round(UNIX_TIMESTAMP(t.updateddate) / 600) desc ORDER BY t.updateddate desc;
END //
DELIMITER //
