DELIMITER //
CREATE PROCEDURE getfinaoscountdet (IN userid INT)
BEGIN
SELECT user_tileid FROM `fn_user_finao_tile` ft JOIN fn_user_finao fu ON fu.`user_finao_id` = ft.`finao_id` WHERE ft.userid =userid AND finao_activestatus !=2;
END //
DELIMITER //
