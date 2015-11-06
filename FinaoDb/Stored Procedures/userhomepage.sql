DELIMITER //
CREATE PROCEDURE userhomepage( IN userid INT ) BEGIN SELECT a.trackingnotification_id, a.tile_id, a.finao_id, a.notification_action, a.updateby, b.updateddate, b.finao_msg, b.finao_status, c.lookup_name, d.profile_image, d.mystory, e.fname, e.lname, f.uploaddetail_id, f.uploadtype, f.upload_text, f.updateddate
FROM  `fn_trackingnotifications` AS a, fn_user_finao AS b, fn_lookups AS c, fn_user_profile AS d, fn_users AS e, fn_uploaddetails AS f
WHERE a.tracker_userid = userid
AND a.notification_action
IN (
'51',  '52',  '53',  '54',  '55',  '56'
)
AND b.user_finao_id = a.finao_id
AND c.lookup_id = a.notification_action
AND e.userid = d.user_id
AND e.userid = a.updateby
AND f.upload_sourceid = a.finao_id
GROUP BY a.finao_id
ORDER BY a.updateddate DESC 
LIMIT 0 , 30;
END //
DELIMITER //
