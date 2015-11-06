DELIMITER //
CREATE PROCEDURE getimagesorvideosrctyperes (IN srcid INT, IN srclookup_id INT, IN user_id INT)
BEGIN
IF srcid!=''
SELECT * from fn_uploaddetails where  upload_sourcetype=srclookup_id and (uploadtype='34'  or uploadtype='62')
AND upload_sourceid= srcid and uploadedby= user_id order by uploaddetail_id DESC;	
ELSE
select * from fn_uploaddetails where  upload_sourcetype=srclookup_id and (uploadtype='35' or uploadtype='62')
and upload_sourceid= srcid and uploadedby= user_id  order by uploaddetail_id DESC ;
END IF;
END //
DELIMITER
