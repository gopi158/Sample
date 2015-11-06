DELIMITER //
CREATE PROCEDURE uploadpath (IN upload_type INT,IN fname VARCHAR(100),IN upload_path VARCHAR(150), IN upload_sourcetype INT, IN finao_id INT ,IN user_id INT ,IN caption VARCHAR(50),IN videoid VARCHAR(20),IN videostatus VARCHAR(20), IN video_img VARCHAR(255), IN video_caption VARCHAR(100))
BEGIN
insert into fn_uploaddetails(uploadtype,uploadfile_name,uploadfile_path,upload_sourcetype,upload_sourceid,uploadedby,uploadeddate,status,updatedby,updateddate,caption,videoid,videostatus,video_img,video_caption)values
(upload_type,fname,upload_path,upload_sourcetype,finao_id,user_id,NOW(),'1',userid,NOW(),caption,videoid,videostatus,video_img,video_caption);
END //
DELIMITER //
