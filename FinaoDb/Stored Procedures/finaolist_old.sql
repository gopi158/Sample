DELIMITER //
CREATE PROCEDURE finaolist_old (IN userid INT )
BEGIN
SELECT * FROM `fn_user_finao_tile` ft join fn_user_finao f WHERE ft.`finao_id`=f.user_finao_id and ft.userid 	= user_id;
END //
DELIMITER //
