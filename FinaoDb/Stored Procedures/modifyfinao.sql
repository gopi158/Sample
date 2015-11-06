DELIMITER //
CREATE PROCEDURE modifyfinao (IN finao_id INT, IN finao_status_ispublic INT, IN updatedby INT, IN finao_status INT )
BEGIN
update fn_user_finao set finao_status_ispublic= finao_status_ispublic, updateddate=NOW(), updatedby=updatedby,finao_status=finao_status, iscompleted=iscompleted where user_finao_id=finao_id;
END //
DELIMITER //
