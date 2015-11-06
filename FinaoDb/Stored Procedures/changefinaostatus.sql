DELIMITER //
DROP PROCEDURE IF EXISTS changefinaostatus //
CREATE PROCEDURE `changefinaostatus`(
      IN user_id INT
    , IN finaoid INT
    , IN status INT
    , IN type INT
    , IN ispublic INT
    )
BEGIN
	DECLARE return_value INT;
	DECLARE s_tatus INT;
	SET autocommit = 0;
	SET return_value := 0;

	IF status = 0
	THEN 
		SELECT lookup_id FROM fn_lookups WHERE lookup_name = 'On Track' INTO s_tatus;
	END IF;
	
	IF status = 1
	THEN 
		SELECT lookup_id FROM fn_lookups WHERE lookup_name = 'Ahead' INTO s_tatus;
	END IF;
	
	IF status = 2
	THEN 
		SELECT lookup_id FROM fn_lookups WHERE lookup_name = 'Behind' INTO s_tatus;
	END IF;

	IF EXISTS ( SELECT finaoid FROM fn_user_finao NOLOCK WHERE userid = user_id AND user_finao_id = finaoid AND 
					finao_activestatus = 1 )
	THEN 
        	IF ( type = 1 )
        	    THEN
			START TRANSACTION ;
        	        UPDATE  fn_user_finao
        	        SET     finao_status_ispublic = ispublic
        	              , updateddate = UTC_TIMESTAMP( )
        	        WHERE   user_finao_id = finaoid
        	                AND userid = user_id;
			SET return_value := 1;
		ELSE 
			IF (status = 1) THEN
				START TRANSACTION ;
        	        UPDATE  fn_user_finao
	        	    SET   finao_status = s_tatus
        		        , Iscompleted = 1
        		        , updateddate = UTC_TIMESTAMP( )
        			WHERE   user_finao_id = finaoid
        		            AND userid = user_id;	
				SET return_value := 1;
			ELSE	
				START TRANSACTION ;
        		    UPDATE  fn_user_finao
        		    SET     finao_status = s_tatus
        		        , updateddate = UTC_TIMESTAMP( )
        		    WHERE   user_finao_id = finaoid
        		        AND userid = user_id;
				SET return_value := 1;
		        END IF;
		END IF;
		SELECT finaoid AS finaoid;
	ELSE
		SIGNAL SQLSTATE '45001' SET 
      		MYSQL_ERRNO = 2009; 
	END IF;

	IF (return_value = 1)
	THEN
        	COMMIT;
        ELSE
	        ROLLBACK;
        END IF;
    END //
    DELIMITER //