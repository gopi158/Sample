DELIMITER //
CREATE PROCEDURE imageselect ()
BEGIN
SELECT t.*,fup.user_profile_id,fup.user_profile_msg,fup.user_location,fup.profile_image,fup.profile_bg_image,fup.profile_status_Ispublic,fup.mystory,fup.IsCompleted,fup.explore_finao,usr.userid,usr.uname,usr.email,usr.fname,usr.lname,fu.finao_msg FROM fn_uploaddetails t JOIN fn_lookups t1 JOIN fn_user_profile fup ON t.uploadtype = t1.lookup_id JOIN fn_users usr on usr.userid=fup.user_id LEFT JOIN fn_user_finao fu on fu.user_finao_id=t.upload_sourceid WHERE lookup_name = 'Image' AND t.explore_finao =1 AND fup.user_id = t.`uploadedby`  AND upload_sourcetype=37;
END //
DELIMITER //
