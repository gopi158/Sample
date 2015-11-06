DELIMITER //
CREATE PROCEDURE getfinao2 (IN finao_id INT)
BEGIN
SELECT uploadfile_name, videoid, videostatus, video_img, video_embedurl FROM fn_user_finao f JOIN fn_uploaddetails fu ON f.user_finao_id = fu.upload_sourceid WHERE user_finao_id = finao_id;
END //
DELIMITER //
