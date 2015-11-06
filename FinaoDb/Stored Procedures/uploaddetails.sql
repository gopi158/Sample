DELIMITER //
CREATE PROCEDURE uploaddetails (IN upload_type INT, IN uploadfile_name VARCHAR(150), IN upload_path VARCHAR(150), IN upload_sourcetype INT, IN upload_sourceid INT, IN user_id INT, IN caption VARCHAR(100), IN videoid VARCHAR(20), IN videostatus VARCHAR(20), IN video_img VARCHAR(255))
BEGIN
insert into fn_uploaddetails(uploadtype,uploadfile_name,uploadfile_path,upload_sourcetype,upload_sourceid,uploadedby,uploadeddate,status,updatedby,updateddate,caption,videoid,videostatus,video_img)values
(upload_type,uploadfile_name,upload_path,upload_sourcetype,id,user_id,NOW(),'1',user_id,NOW(),caption,videoid,videostatus,video_img);
END //
DELIMITER //
