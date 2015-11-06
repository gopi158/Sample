DELIMITER //
CREATE PROCEDURE imgdata (IN qry INT)
BEGIN
SELECT uploadfile_name, caption FROM fn_images WHERE upload_id=qry ORDER BY image_id DESC LIMIT 1;
END //
DELIMITER //
