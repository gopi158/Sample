DELIMITER //
CREATE PROCEDURE finao_details (IN userid INT, IN finaoid INT)
BEGIN
SELECT * FROM ( (SELECT fu. * , t.finao_msg AS message FROM fn_uploaddetails fu LEFT JOIN fn_user_finao t ON fu.upload_sourceid = t.user_finao_id WHERE fu.updatedby = userid AND upload_sourcetype =37 AND t.user_finao_id =finaoid ORDER BY fu.`uploaddetail_id` DESC ) )a ORDER BY a.updateddate DESC;
END //
DELIMITER //
