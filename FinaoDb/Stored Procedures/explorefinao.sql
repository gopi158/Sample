DELIMITER //
CREATE PROCEDURE explorefinao (IN userid INT)
BEGIN
IF userid != ''
SELECT t. * ,usr.*, t1.finao_msg, fup.profile_image,fud.uploadfile_name, t4.lookup_name AS finaostatus, t1.updateddate AS finaoupdateddate, t2.fname, t2.lname, t3.lookup_name, t5.tile_id FROM `fn_trackingnotifications` `t` JOIN fn_user_finao t1 ON t.finao_id = t1.user_finao_id JOIN fn_users t2 ON t.updateby = t2.userid JOIN fn_lookups t3 ON t.notification_action = t3.lookup_id AND t3.lookup_type = 'notificationaction' JOIN fn_lookups t4 ON t1.finao_status = t4.lookup_id AND t4.lookup_type = 'finaostatus' JOIN fn_user_finao_tile t5 ON t1.user_finao_id = t5.finao_id JOIN fn_user_profile fup ON fup.user_id = t2.userid JOIN fn_uploaddetails fud ON fud.`uploadedby`=t2.userid JOIN fn_users usr on usr.userid=fup.user_id WHERE t1.finao_status_Ispublic =1  AND t.tracker_userid =userid;
ELSE
SELECT t. * ,usr.*, t1.finao_msg, fup.profile_image,fud.uploadfile_name, t4.lookup_name AS finaostatus, t1.updateddate AS finaoupdateddate, t2.fname, t2.lname, t3.lookup_name, t5.tile_id FROM `fn_trackingnotifications` `t` JOIN fn_user_finao t1 ON t.finao_id = t1.user_finao_id JOIN fn_users t2 ON t.updateby = t2.userid JOIN fn_lookups t3 ON t.notification_action = t3.lookup_id AND t3.lookup_type = 'notificationaction' JOIN fn_lookups t4 ON t1.finao_status = t4.lookup_id AND t4.lookup_type = 'finaostatus' JOIN fn_user_finao_tile t5 ON t1.user_finao_id = t5.finao_id JOIN fn_user_profile fup ON fup.user_id = t2.userid JOIN fn_uploaddetails fud ON fud.`uploadedby`=t2.userid JOIN fn_users usr on usr.userid=fup.user_id WHERE t1.finao_status_Ispublic =1 AND t3.lookup_name!='Image' AND t3.lookup_name!='Video' AND t1.finao_activestatus =1 GROUP BY t.tile_id, t.finao_id,round( UNIX_TIMESTAMP( t.updateddate ) /600 ) DESC ORDER BY t.updateddate DESC limit 0,30;
ENDIF;
END //
DELIMITER 
