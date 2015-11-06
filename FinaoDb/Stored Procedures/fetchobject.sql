DELIMITER //
CREATE PROCEDURE fetchobject (IN obj INT)
BEGIN
SELECT uploaddetail_id, uploadtype, upload_text FROM fn_uploaddetails WHERE upload_sourcetype=37 AND upload_sourceid= obj ORDER BY uploaddetail_id DESC;
END //
DELIMITER //
