DELIMITER //
CREATE PROCEDURE selectuserprofile (IN userid INT, IN tile_id INT, IN username VARCHAR(150))
BEGIN
IF (username !='')
SELECT t.tile_id FROM `fn_trackingnotifications` `t` JOIN fn_user_finao t1 ON t.finao_id = t1.user_finao_id JOIN fn_users t2 ON t.updateby = t2.userid JOIN fn_lookups t3 ON t.notification_action = t3.lookup_id AND t3.lookup_type = 'notificationaction' JOIN fn_lookups t4 ON t1.finao_status = t4.lookup_id AND t4.lookup_type = 'finaostatus' JOIN fn_user_finao_tile t5 ON t1.user_finao_id = t5.finao_id WHERE t.tracker_userid =userid AND t1.finao_status_Ispublic =1 AND t1.finao_activestatus =1 GROUP BY t.tile_id DESC ORDER BY t.updateddate DESC;
SELECT t . * , t1.finao_msg, t4.lookup_name AS finaostatus, t1.updateddate AS finaoupdateddate, t2.fname, t2.lname, t3.lookup_name, t5.tile_id,t5.tile_name,t5.tile_profileImagurl,t5.status,t5.createddate,t5.createdby,t5.updateddate,t5.updatedby,t5.explore_finao,fd.uploadfile_name as tile_image,fd.uploadfile_path
FROM `fn_trackingnotifications` `t`
JOIN fn_user_finao t1 ON t.finao_id = t1.user_finao_id
JOIN fn_users t2 ON t.updateby = t2.userid
JOIN fn_lookups t3 ON t.notification_action = t3.lookup_id
AND t3.lookup_type = 'notificationaction'
JOIN fn_lookups t4 ON t1.finao_status = t4.lookup_id
AND t4.lookup_type = 'finaostatus'
JOIN fn_user_finao_tile t5 
LEFT JOIN fn_uploaddetails fd
ON t1.user_finao_id = t5.finao_id 
WHERE t.tracker_userid =userid
AND fd.`upload_sourceid` = t5.`finao_id`
AND t1.finao_status_Ispublic =1
AND t1.finao_activestatus =1
GROUP BY t.tile_id,finao_id DESC
ORDER BY t.updateddate DESC;
ELSE
SELECT t . * , t1.finao_msg, t4.lookup_name AS finaostatus, t1.updateddate AS finaoupdateddate, t2.fname, t2.lname, t3.lookup_name, t5.tile_id,t5.tile_name,t5.tile_profileImagurl,t5.status,t5.createddate,t5.createdby,t5.updateddate,t5.updatedby,t5.explore_finao,fd.uploadfile_name as tile_image,fd.uploadfile_path
FROM `fn_trackingnotifications` `t`
JOIN fn_user_finao t1 ON t.finao_id = t1.user_finao_id
JOIN fn_users t2 ON t.updateby = t2.userid
JOIN fn_lookups t3 ON t.notification_action = t3.lookup_id
AND t3.lookup_type = 'notificationaction'
JOIN fn_lookups t4 ON t1.finao_status = t4.lookup_id
AND t4.lookup_type = 'finaostatus'
JOIN fn_user_finao_tile t5 
LEFT JOIN fn_uploaddetails fd
ON t1.user_finao_id = t5.finao_id 
WHERE t.tracker_userid =userid
AND t.tile_id =tile_id
AND fd.`upload_sourceid` = t5.`finao_id`
AND t1.finao_status_Ispublic =1
AND t1.finao_activestatus =1
GROUP BY t.tile_id,finao_id DESC
ORDER BY t.updateddate DESC;
END IF;
END 
DELIMITER //
