SELECT notification.trackingnotification_id, 
notification.tile_id, 
notification.finao_id, 
notification.notification_action, 
notification.updateby, 
finao.updateddate, 
finao.finao_msg, 
finao.finao_status, 
lookup.lookup_name, 
profile.profile_image, 
profile.mystory, 
usr.fname, 
usr.lname, 
upload.uploaddetail_id, 
upload.uploadtype, 
upload.upload_text, 
upload.updateddate
FROM `fn_trackingnotifications` AS notification 
INNER JOIN fn_user_finao AS finao ON finao.user_finao_id=notification.finao_id  
INNER JOIN fn_lookups AS lookup ON lookup.lookup_id= notification.notification_action 
INNER JOIN fn_user_profile AS profile 
INNER JOIN fn_users AS usr ON usr.userid= profile.user_id AND usr.userid= notification.updateby 
INNER JOIN fn_uploaddetails AS upload ON upload.upload_sourceid= notification.finao_id
LEFT OUTER JOIN inappropriatepost inapp ON inapp.userpostid = upload.uploaddetail_id
WHERE notification.tracker_userid = id AND
notification.notification_action IN ('51','52','53','54','55','56') AND
inapp.userpostid IS NULL 
GROUP BY notification.finao_id
ORDER BY notification.updateddate DESC