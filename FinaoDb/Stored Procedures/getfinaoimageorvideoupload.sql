DELIMITER //
CREATE PROCEDURE getfinaoimageorvideoupload (IN lookup_id INT, srclookup_id INT, IN user_id INT)
BEGIN
select * from fn_uploaddetails where uploadtype= lookup_id and upload_sourcetype= srclookup_id and uploadedby= user_id;
END //
DELIMITER //
