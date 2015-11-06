DELIMITER //
CREATE PROCEDURE getimageorvideodetailupload (IN lookup_id INT, IN srclookup_id INT, IN srcid INT, IN user_id INT)
BEGIN
select * from fn_uploaddetails where uploadtype=lookup_id and upload_sourcetype=srclookup_id and upload_sourceid=srcid and uploadedby=user_id;
END //
DELIMITER //
