DELIMITER //
CREATE PROCEDURE fngetTotalFinaos (IN user_id INT, IN actual_user_id INT )
BEGIN

IF actual_user_id = ''
THEN
SELECT count( * ) AS totalfinaos FROM `fn_user_finao_tile` ft JOIN fn_user_finao f ON ft.`finao_id` = f.user_finao_id WHERE ft.userid =user_id AND f.finao_activestatus =1 and finao_status_Ispublic = 1 and Iscompleted =0	;
ELSEIF actual_user_id <> ''
THEN
SELECT count( * ) AS totalfinaos FROM `fn_user_finao_tile` ft JOIN fn_user_finao f ON ft.`finao_id` = f.user_finao_id WHERE ft.userid =user_id AND f.finao_activestatus =1 and finao_status_Ispublic = 1 and `finao_status_Ispublic` =1;
ELSEIF actual_user_id = 'search'
THEN
SELECT count( * ) AS totalfinaos FROM `fn_user_finao_tile` ft JOIN fn_user_finao f ON ft.`finao_id` = f.user_finao_id WHERE ft.userid =user_id AND f.finao_activestatus =1 and finao_status_Ispublic = 1 and `finao_status_Ispublic` =1;
END IF;
END //
DELIMITER ;

