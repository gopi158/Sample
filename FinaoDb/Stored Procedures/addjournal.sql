DELIMITER //
DROP PROCEDURE IF EXISTS addjournal //
CREATE PROCEDURE addjournal
    (
      IN finaoid INT
    , IN journal VARCHAR(500)
    , IN journalstatus INT
    , IN user_id INT
    , IN statusvalue INT 
    )
    BEGIN
	DECLARE return_value INT;
	SET autocommit = 0;
	SET return_value := 0;

	IF EXISTS (SELECT user_finao_id FROM fn_user_finao WHERE user_finao_id = finaoid AND userid = user_id AND 				finao_activestatus = 1)
		THEN
		START TRANSACTION ;
	        INSERT  INTO fn_user_finao_journal
	                ( finao_id
	                , finao_journal
	                , journal_status
	                , journal_startdate
	                , user_id
	                , status_value
	                , createdby
	                , createddate
	                , updatedby
	                , updateddate
	                )
	                SELECT  finaoid
        	              , journal
	                      , journalstatus
        	              , NOW()
        	              , user_id
        	              , statusvalue
        	              , user_id
        	              , NOW()
        	              , user_id
        	              , NOW();
		SET return_value := 1;
        	SELECT  last_insert_id() AS journal_id;
	ELSE
		SIGNAL SQLSTATE '45001' SET 
      		MYSQL_ERRNO = 2009,
      		MESSAGE_TEXT = 'Finao does not exist!'; 
	END IF;

	IF (return_value = 1)
	THEN
        	COMMIT;
        ELSE
	        ROLLBACK;
        END IF;
    END //
DELIMITER //
