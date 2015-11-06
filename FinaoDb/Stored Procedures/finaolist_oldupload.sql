DELIMITER //
CREATE PROCEDURE finaolist_oldupload ()
BEGIN
select * from fn_uploaddetails where uploadtype='34' and Lower(upload_sourcetype)='37'; 
END //
DELIMITER //
