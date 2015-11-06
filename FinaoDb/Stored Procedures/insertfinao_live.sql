DELIMITER //
CREATE PROCEDURE insertfinao_live (IN userid INT, IN finao_msg VARCHAR(200), IN finao_status_ispublic INT, IN updatedby INT, IN finao_status INT, IN iscompleted TINYINT)
BEGIN
insert into fn_user_finao (userid,finao_msg,finao_status_ispublic,updatedby,finao_status,iscompleted,createddate,updateddate)values
(userid,finao_msg,finao_status_ispublic,updatedby,finao_status,iscompleted,NOW(),NOW());
END //
DELIMITER //
