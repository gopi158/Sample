DELIMITER //
CREATE PROCEDURE inseruploaddetails (IN id INT,IN upload_type INT,IN uploadfile_name VARCHAR(150), IN upload_text VARCHAR(250), IN upload_path VARCHAR(150), IN upload_sourcetype INT, IN user_id INT,IN caption VARCHAR(100), IN videoid VARCHAR(20),IN videostatus VARCHAR(20), IN video_img VARCHAR(255), IN video_caption VARCHAR(150))
BEGIN
insert into fn_uploaddetails(uploadtype,uploadfile_name,upload_text,uploadfile_path,upload_sourcetype,upload_sourceid,uploadedby,uploadeddate,status,updatedby,updateddate,caption,videoid,videostatus,video_img,video_caption)values
(upload_type,uploadfile_name,upload_text,upload_path,upload_sourcetype,id,user_id,NOW(),'1',user_id,NOW(),caption,videoid,videostatus,video_img,video_caption);
END //
DELIMITER //
