DELIMITER //
CREATE PROCEDURE recentpost (IN uid INT)
BEGIN
select user_finao_id from fn_user_finao where userid = uid AND finao_activestatus=1 AND Iscompleted=0 order by user_finao_id DESC;
END //
DELIMITER //
