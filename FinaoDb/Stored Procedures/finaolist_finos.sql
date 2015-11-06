DELIMITER //
CREATE PROCEDURE finaolist_finos ( IN user_id INT)
BEGIN
SELECT * FROM `fn_user_finao_tile` ft join fn_user_finao f ON ft.`finao_id`=f.user_finao_id  and ft.userid 	= user_id;
END //
DELIMITER //
