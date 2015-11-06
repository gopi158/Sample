DELIMITER //
DROP PROCEDURE IF EXISTS getfinaolist //
CREATE PROCEDURE getfinaolist (IN user_id INT, IN type INT, IN otherid INT)
BEGIN
	IF EXISTS (SELECT user_finao_id FROM fn_user_finao WHERE userid = user_id AND type != NULL)
	THEN
		IF ( type = 0 ) 
		THEN
			SELECT  finao.user_finao_id
				, finao.finao_msg
				, finao.finao_status
				, finao.Iscompleted
				, finao.finao_status_Ispublic
				, tile.tile_id
			FROM    fn_user_finao AS finao
			INNER JOIN fn_user_finao_tile AS tile ON tile.finao_id = finao.user_finao_id
			WHERE   finao.finao_activestatus = 1
			AND finao.userid = user_id
			AND finao.Iscompleted = 0
			ORDER BY finao.updateddate DESC; 
      
	        ELSE 
			SELECT  finao.user_finao_id
		          , finao.finao_msg
		          , finao.finao_status
		          , finao.Iscompleted
		          , finao.finao_status_Ispublic
		          , tile.tile_id
		    FROM    fn_user_finao AS finao
		    INNER JOIN fn_user_finao_tile AS tile ON tile.finao_id = finao.user_finao_id
		    WHERE   finao.finao_activestatus = 1
	            AND finao.userid = otherid
        	    AND finao.Iscompleted = 0
		    ORDER BY finao.updateddate DESC; 
		END IF;
	ELSE
		SIGNAL SQLSTATE '45001' SET 
      		MYSQL_ERRNO = 2001,
      		MESSAGE_TEXT = 'User does not exist!'; 
	END IF;
END //
DELIMITER //
