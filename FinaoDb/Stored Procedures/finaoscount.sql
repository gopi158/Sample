DELIMITER //
CREATE PROCEDURE finaoscount (IN userid INT)
BEGIN
SELECT count( * ) AS totalfinaos FROM `fn_user_finao_tile` ft JOIN fn_user_finao f ON ft.`finao_id` = f.user_finao_id WHERE ft.userid =userid AND f.finao_activestatus =1 AND Iscompleted =0 and finao_status_Ispublic = 1;
END //
DELIMITER //
