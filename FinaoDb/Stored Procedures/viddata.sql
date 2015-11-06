DELIMITER //
CREATE PROCEDURE viddata (IN qry INT)
BEGIN
SELECT uploadfile_name, caption FROM fn_videos WHERE upload_id=qry ORDER BY image_id DESC;
END //
DELIMITER //
