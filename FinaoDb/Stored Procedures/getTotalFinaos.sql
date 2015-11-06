DELIMITER //
CREATE PROCEDURE getTotalFinaos (IN user_id INT, IN actual_user_id INT )
BEGIN
IF actual_user_id = ''
THEN
SELECT * FROM `fn_user_finao_tile` ft join fn_user_finao f WHERE ft.`finao_id`=f.user_finao_id and ft.userid = user_id AND f.finao_activestatus =1 and Iscompleted =0;
ELSEIF actual_user_id <> ''
THEN
SELECT * FROM `fn_user_finao_tile` ft join fn_user_finao f WHERE ft.`finao_id`=f.user_finao_id and ft.userid = user_id AND f.finao_activestatus =1 and `finao_status_Ispublic` =1;
ELSEIF actual_user_id = 'search'
THEN
SELECT * FROM `fn_user_finao_tile` ft join fn_user_finao f WHERE ft.`finao_id`=f.user_finao_id and ft.userid = user_id AND f.finao_activestatus =1 and `finao_status_Ispublic` =1;
END IF;
END //
DELIMITER ;

