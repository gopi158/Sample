DELIMITER //
CREATE PROCEDURE updatelist ()
BEGIN
SELECT fu.updateddate, fu.uploadfile_name, uname, lookup_name, upload_sourceid FROM fn_uploaddetails fu JOIN fn_users fur RIGHT JOIN fn_lookups fl ON fu.updatedby = fur.userid AND fu.upload_sourcetype = fl.lookup_id WHERE (lookup_name = 'tile' OR lookup_name = 'finao' OR lookup_name = 'journal' )ORDER BY fu.updateddate DESC LIMIT 0,30;
END //
DELIMITER //
