DELIMITER //
CREATE PROCEDURE updatefinaochange (IN finao_id INT, IN user_id INT)
BEGIN
update fn_uploaddetails set uploadfile_name=finao_id.image name.updatedby=user_id,updateddate=NOW() where upload_sourceid=finao_id and uploadedby=user_id and (uploadtype=34 or uploadtype=62) and upload_sourcetype=37;
END //
DELIMITER //
