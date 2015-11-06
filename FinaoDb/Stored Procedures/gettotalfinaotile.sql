DELIMITER //
CREATE PROCEDURE gettotalfinaotile (IN userid INT, IN actual_user_id VARCHAR(25))
BEGIN
if(actual_user_id='')	
SELECT * FROM `fn_user_finao_tile` ft join fn_user_finao f WHERE ft.`finao_id`=f.user_finao_id and ft.userid =userid AND f.finao_activestatus =1 and Iscompleted =0;
ELSE IF (actual_user_id!='')
SELECT * FROM `fn_user_finao_tile` ft join fn_user_finao f WHERE ft.`finao_id`=f.user_finao_id and ft.userid =userid AND f.finao_activestatus =1 and `finao_status_Ispublic` =1;	
ELSE IF (actual_user_id='search')
SELECT * FROM `fn_user_finao_tile` ft join fn_user_finao f WHERE ft.`finao_id`=f.user_finao_id and ft.userid =userid AND f.finao_activestatus =1 and `finao_status_Ispublic` =1;	
END IF;
END //
DELIMITER 
